<?php

namespace App\Http\Controllers\Inventory\Purchase;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\FinancialYear;
use App\Models\ParentCategory;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Support\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PurchaseOrderController extends Controller
{
    use JsonResponses;

    public function index(Request $request): View
    {
        $orders = PurchaseOrder::with(['unit', 'supplier', 'financialYear', 'items'])
            ->tap(fn ($q) => $this->scopeUnit($q, $request))
            ->when($request->filled('PONo'), fn ($q) => $q->where('po_no', 'like', "%{$request->PONo}%"))
            ->when($request->filled('Date'), fn ($q) => $q->whereDate('date', $request->Date))
            ->when($request->filled('Supplier'), fn ($q) => $q->where('supplier_id', $request->Supplier))
            ->when($request->filled('FinYear'), fn ($q) => $q->where('financial_year_id', $request->FinYear))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('inventory.purchase.orders.index', ['orders' => $orders] + $this->options());
    }

    public function create(): View
    {
        return view('inventory.purchase.orders.form', ['order' => new PurchaseOrder(['date' => now(), 'priority' => 3]), 'lines' => []] + $this->options());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->validated($request);

        $order = DB::transaction(function () use ($request, $data) {
            $order = PurchaseOrder::create($this->payload($data, $request) + ['po_no' => uniqid('tmp'), 'unit_id' => $request->user()->unit_id]);
            $order->update(['po_no' => PurchaseOrder::makeNumber($order->id, $order->financialYear->name)]);
            foreach ($data['items'] as $line) {
                $order->items()->create(['item_id' => $line['pid'], 'order_qty' => $line['qty']]);
            }

            return $order;
        });

        return $this->ok($order->isPending() ? 'Purchase Order submitted for QM approval.' : 'Purchase Order created successfully.', ['redirect' => route('inventory.purchase.purchaseorders.show', $order)]);
    }

    public function show(Request $request, PurchaseOrder $purchaseorder): View
    {
        $this->authorizeUnit($request, $purchaseorder);
        $purchaseorder->load(['unit', 'supplier', 'financialYear', 'creator', 'items.item.category', 'items.item.brand', 'items.item.productModel', 'items.item.unit']);

        return view('inventory.purchase.orders.show', ['order' => $purchaseorder]);
    }

    public function pdf(Request $request, PurchaseOrder $purchaseorder): Response
    {
        $this->authorizeUnit($request, $purchaseorder);
        $purchaseorder->load(['unit', 'supplier', 'financialYear', 'creator', 'items.item.category', 'items.item.brand', 'items.item.productModel', 'items.item.unit']);

        return Pdf::stream('pdf.purchase-order', ['order' => $purchaseorder], 'Purchase Order Details', str_replace('/', '-', $purchaseorder->po_no));
    }

    public function edit(Request $request, PurchaseOrder $purchaseorder): View
    {
        $this->authorizeUnit($request, $purchaseorder);
        $purchaseorder->load('items.item');
        $lines = $purchaseorder->items->map(fn ($l) => [
            'pid' => $l->item_id, 'code' => $l->item->code, 'name' => $l->item->name, 'qty' => $l->order_qty, 'received' => $l->received_qty,
        ])->all();

        return view('inventory.purchase.orders.form', ['order' => $purchaseorder, 'lines' => $lines] + $this->options());
    }

    public function update(Request $request, PurchaseOrder $purchaseorder): JsonResponse
    {
        $this->authorizeUnit($request, $purchaseorder);
        $data = $this->validated($request, $purchaseorder);
        $existing = $purchaseorder->items()->get()->keyBy('item_id');

        // Received lines can't be removed or reduced below what has arrived.
        foreach ($existing as $itemId => $line) {
            $new = collect($data['items'])->firstWhere('pid', $itemId);
            if ($line->received_qty > 0 && (! $new || $new['qty'] < $line->received_qty)) {
                return $this->fail('Validation failed.', ['Items' => ["{$line->item->code}: order quantity can not be less than the received quantity ({$line->received_qty})."]]);
            }
        }

        DB::transaction(function () use ($request, $data, $purchaseorder, $existing) {
            if ($request->hasFile('attchfile') && $purchaseorder->attachment) {
                Storage::disk('public')->delete($purchaseorder->attachment);
            }
            $purchaseorder->update($this->payload($data, $request, $purchaseorder));
            $keep = collect($data['items'])->pluck('pid')->all();
            $purchaseorder->items()->whereNotIn('item_id', $keep)->delete();
            foreach ($data['items'] as $line) {
                $existing->has($line['pid'])
                    ? $existing[$line['pid']]->update(['order_qty' => $line['qty']])
                    : $purchaseorder->items()->create(['item_id' => $line['pid'], 'order_qty' => $line['qty']]);
            }
        });

        return $this->ok('Purchase Order updated successfully.', ['redirect' => route('inventory.purchase.purchaseorders.show', $purchaseorder)]);
    }

    public function destroy(Request $request, PurchaseOrder $purchaseorder): JsonResponse
    {
        $this->authorizeUnit($request, $purchaseorder);
        if ($purchaseorder->receives()->exists()) {
            return $this->fail('This Purchase Order has received items and can not be deleted.');
        }
        if ($purchaseorder->attachment) {
            Storage::disk('public')->delete($purchaseorder->attachment);
        }
        $purchaseorder->delete();

        return $this->ok('Purchase Order deleted successfully.', ['id' => $purchaseorder->id]);
    }

    private function validated(Request $request, ?PurchaseOrder $order = null): array
    {
        return $this->check($request, [
            'Date' => ['required', 'date'],
            'SupplierID' => ['required', Rule::exists('suppliers', 'id')->where('status', true)],
            'FinYearID' => ['required', Rule::exists('financial_years', 'id')->where('status', true)],
            'ReferenceNo' => ['required', 'string', 'max:250'],
            'Priority' => ['required', Rule::in(array_keys(PurchaseOrder::PRIORITIES))],
            'attchfile' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'Comments' => ['nullable', 'string', 'max:250'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.pid' => ['required', 'distinct', Rule::exists('items', 'id')->where('status', true)],
            'items.*.qty' => ['required', 'integer', 'min:1'],
        ], [
            'SupplierID' => 'Supplier', 'FinYearID' => 'Financial Year', 'ReferenceNo' => 'Reference No', 'attchfile' => 'Scan Copy',
            'items' => 'Items', 'items.*.pid' => 'Item', 'items.*.qty' => 'Required Qty',
        ]);
    }

    private function payload(array $d, Request $request, ?PurchaseOrder $order = null): array
    {
        return array_filter([
            'date' => $d['Date'], 'supplier_id' => $d['SupplierID'], 'financial_year_id' => $d['FinYearID'],
            'reference_no' => $d['ReferenceNo'], 'priority' => $d['Priority'], 'comments' => $d['Comments'] ?? null,
            'attachment' => $request->file('attchfile')?->store('purchase-orders', 'public') ?? $order?->attachment,
        ], fn ($v, $k) => $v !== null || $k === 'comments', ARRAY_FILTER_USE_BOTH);
    }

    private function options(): array
    {
        return [
            'suppliers' => Supplier::active()->orderBy('name')->pluck('name', 'id'),
            'finYears' => FinancialYear::active()->orderByDesc('is_current')->orderBy('name')->pluck('name', 'id'),
            'currentFinYear' => FinancialYear::current()?->id,
            'parents' => ParentCategory::active()->orderBy('name')->pluck('name', 'id'),
        ];
    }

    /** Each wing works on its own records; Super Admin sees all. */
    private function scopeUnit($query, Request $request): void
    {
        if (! $request->user()->isSuperAdmin()) {
            $query->where('unit_id', $request->user()->unit_id);
        }
    }

    private function authorizeUnit(Request $request, PurchaseOrder $order): void
    {
        abort_unless($request->user()->isSuperAdmin() || $order->unit_id === $request->user()->unit_id, 404);
    }
}
