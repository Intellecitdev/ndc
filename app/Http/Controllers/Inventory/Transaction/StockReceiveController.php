<?php

namespace App\Http\Controllers\Inventory\Transaction;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Concerns\ScopesUnit;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\IssueVoucherItem;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Stock issued to this wing by another wing: receive it into stock, or return it.
 */
class StockReceiveController extends Controller
{
    use JsonResponses, ScopesUnit;

    public function index(Request $request): View
    {
        $type = $request->input('TypeID', 4); // Pending by default
        $status = ['4' => 'Pending', '1' => 'Received', '3' => 'Returned'][(string) $type] ?? null;

        $rows = $this->scopeUnit(IssueVoucherItem::query()->with(['voucher.fromUnit', 'stock.item.category', 'stock.item.unit']), $request, 'to_unit_id')
            ->whereHas('voucher', fn ($q) => $q->approved()) // vouchers still waiting for the QM aren't sent yet

            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($request->filled('Serial'), fn ($q) => $q->whereHas('stock', fn ($q) => $q->where('serial_no', 'like', "%{$request->Serial}%")))
            ->when($request->filled('Name'), fn ($q) => $q->whereHas('stock.item', fn ($q) => $q->where('name', 'like', "%{$request->Name}%")))
            ->when($request->filled('CategoryID'), fn ($q) => $q->whereHas('stock.item', fn ($q) => $q->where('category_id', $request->CategoryID)))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('inventory.transaction.stockreceive', [
            'rows' => $rows,
            'type' => (string) $type,
            'categories' => Category::active()->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    /** formNo 1 = receive into this wing's stock, 2 = return to the issuing wing. */
    public function update(Request $request, IssueVoucherItem $stockreceive): JsonResponse
    {
        $row = $stockreceive->load(['stock', 'voucher']);
        abort_unless($this->ownsUnit($request, $row->to_unit_id), 404);
        abort_unless($row->voucher->isApproved(), 404);
        if ($row->status !== 'Pending') {
            return $this->fail('This stock has already been '.strtolower($row->status).'.');
        }

        $receive = (int) $request->input('formNo') !== 2;
        DB::transaction(function () use ($row, $receive, $request) {
            $row->update(['status' => $receive ? 'Received' : 'Returned', 'actioned_by' => $request->user()->id, 'actioned_at' => now()]);
            $row->stock->update([
                'status' => Stock::IN_STOCK,
                'unit_id' => $receive ? $row->to_unit_id : $row->voucher->from_unit_id,
            ]);
        });

        return $this->ok($receive ? 'Stock received successfully.' : 'Stock returned successfully.');
    }
}
