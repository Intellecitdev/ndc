<?php

namespace App\Http\Controllers\Inventory\Transaction;

use App\Http\Controllers\Concerns\ScopesUnit;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Support\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class BarcodeController extends Controller
{
    use ScopesUnit;

    public function index(Request $request): View
    {
        $stocks = $this->scopeUnit(Stock::query()->with(['item.category', 'item.productModel', 'supplier']), $request)
            ->whereNull('parent_id')
            ->when($request->filled('Serial'), fn ($q) => $q->where('serial_no', 'like', "%{$request->Serial}%"))
            ->when($request->filled('Name'), fn ($q) => $q->whereHas('item', fn ($q) => $q->where('name', 'like', "%{$request->Name}%")))
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('inventory.transaction.barcodes', compact('stocks'));
    }

    /** Bulk Print page: scan or search products, pick them, print their labels together. */
    public function bulk(): View
    {
        return view('inventory.transaction.barcodes-bulk');
    }

    /**
     * Rows for the bulk page. ?code= is a scan (exact serial, or item code for consumables);
     * ?q= is a search on serial, item code or item name.
     */
    public function search(Request $request): JsonResponse
    {
        $code = trim((string) $request->code);
        $term = trim((string) $request->q);

        $rows = $this->labels($request)
            ->when($code !== '', fn ($q) => $q->where(fn ($q) => $q->where('serial_no', $code)
                ->orWhere(fn ($q) => $q->whereNull('serial_no')->whereHas('item', fn ($q) => $q->where('code', $code)))))
            ->when($code === '' && $term !== '', fn ($q) => $q->where(fn ($q) => $q->where('serial_no', 'like', "%{$term}%")
                ->orWhereHas('item', fn ($q) => $q->where('name', 'like', "%{$term}%")->orWhere('code', 'like', "%{$term}%"))))
            ->when($code === '' && $term === '', fn ($q) => $q->whereRaw('1 = 0'))
            ->orderBy('id')->limit($code !== '' ? 1 : 50)->get()
            ->map(fn (Stock $s) => [
                'id' => $s->id, 'serial' => $s->label(), 'name' => $s->item->name, 'category' => $s->item->category?->name,
                'supplier' => $s->supplier?->name, 'status' => $s->status,
            ]);

        return response()->json(['success' => true, 'rows' => $rows]);
    }

    /** Printable labels only (barcode + serial + name); the page opens the print dialog itself. */
    public function print(Request $request): View
    {
        $ids = collect((array) $request->input('ids', []))->map(fn ($id) => (int) $id)->filter()->unique();
        $copies = max(1, min(50, (int) $request->input('copies', 1)));
        $stocks = $this->labels($request)->whereIn('id', $ids)->get()->sortBy(fn ($s) => $ids->search($s->id))->values();
        abort_if($stocks->isEmpty(), 404);

        return view('inventory.transaction.barcodes-print', compact('stocks', 'copies'));
    }

    private function labels(Request $request)
    {
        return $this->scopeUnit(Stock::query()->with(['item.category', 'supplier']), $request)->whereNull('parent_id');
    }

    public function pdf(Request $request, Stock $stock): Response
    {
        abort_unless($this->ownsUnit($request, $stock->unit_id), 404);

        return Pdf::stream('pdf.barcode', ['stock' => $stock->load(['item.category', 'supplier'])], 'Bar Code', 'barcode-'.$stock->label());
    }
}
