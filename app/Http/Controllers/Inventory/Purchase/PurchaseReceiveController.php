<?php

namespace App\Http\Controllers\Inventory\Purchase;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceive;
use App\Models\Stock;
use App\Models\Supplier;
use App\Support\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PurchaseReceiveController extends Controller
{
    use JsonResponses;

    private const DETAIL = ['unit', 'supplier', 'financialYear', 'creator', 'purchaseOrder', 'items.item.category', 'items.item.brand', 'items.item.productModel', 'stocks.item.category', 'stocks.item.brand', 'stocks.item.productModel'];

    public function index(Request $request): View
    {
        $receives = PurchaseReceive::with(['unit', 'supplier', 'purchaseOrder'])
            ->when(! $request->user()->isSuperAdmin(), fn ($q) => $q->where('unit_id', $request->user()->unit_id))
            ->when($request->filled('InvoiceNo'), fn ($q) => $q->where('invoice_no', 'like', "%{$request->InvoiceNo}%"))
            ->when($request->filled('Date'), fn ($q) => $q->whereDate('date', $request->Date))
            ->when($request->filled('Supplier'), fn ($q) => $q->where('supplier_id', $request->Supplier))
            ->when($request->filled('PONo'), fn ($q) => $q->whereHas('purchaseOrder', fn ($q) => $q->where('po_no', 'like', "%{$request->PONo}%")))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('inventory.purchase.receives.index', [
            'receives' => $receives,
            'suppliers' => Supplier::active()->orderBy('name')->pluck('name', 'id'),
        ]);
    }

    public function create(Request $request): View
    {
        return view('inventory.purchase.receives.create', ['orders' => $this->openOrders($request)]);
    }

    /**
     * Header of a PO plus its lines with what is still due (reference: getpurchasedetails).
     */
    public function details(Request $request, PurchaseOrder $order): JsonResponse
    {
        abort_unless($this->canReceive($request), 403);
        abort_unless($request->user()->isSuperAdmin() || $order->unit_id === $request->user()->unit_id, 404);
        $order->load(['supplier', 'financialYear', 'items.item']);

        return response()->json([
            'success' => true,
            'data' => ['id' => $order->id, 'po_no' => $order->po_no, 'supplier_id' => $order->supplier_id, 'supplier' => $order->supplier?->name, 'fin_year' => $order->financialYear?->name],
            'items' => $order->items->map(fn ($l) => [
                'id' => $l->id, 'code' => $l->item->code, 'name' => $l->item->name, 'order_qty' => $l->order_qty,
                'received_qty' => $l->received_qty, 'due_qty' => $l->dueQty(),
                'consumable' => $l->item->is_consumable, 'warranty' => $l->item->has_warranty,
            ])->values(),
        ]);
    }

    /** Serial numbers must be unique across the whole stock (reference: serialnochecking). */
    public function serialCheck(Request $request): JsonResponse
    {
        abort_unless($this->canReceive($request), 403);
        $exists = Stock::where('serial_no', $request->input('SerialNo'))
            ->when($request->filled('RID'), fn ($q) => $q->where('id', '!=', $request->RID))
            ->exists();

        return $exists
            ? $this->fail('Serial No '.$request->input('SerialNo').' already exists!')
            : $this->ok('Serial No is available.');
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->check($request, [
            'Date' => ['required', 'date'],
            'InvoiceNo' => ['required', 'string', 'max:100'],
            'POID' => ['required', 'exists:purchase_orders,id'],
            'ReceivedQty' => ['required', 'integer', 'min:1'],
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:purchase_order_items,id'],
            'items.*.qty' => ['nullable', 'integer', 'min:0'],
            'items.*.serial' => ['nullable', 'array'],
            'items.*.serial.*' => ['required', 'string', 'min:3', 'max:100', 'distinct', 'unique:stocks,serial_no'],
            'items.*.type' => ['nullable', Rule::in(['Warranty', 'Service'])],
            'items.*.startdate' => ['nullable', 'required_with:items.*.type', 'date'],
            'items.*.duration' => ['nullable', 'required_with:items.*.type', 'integer', 'min:1'],
            'items.*.dtype' => ['nullable', 'required_with:items.*.type', Rule::in(['Days', 'Months', 'Years'])],
            'items.*.terms' => ['nullable', 'string', 'max:1000'],
        ], [
            'InvoiceNo' => 'Invoice No', 'POID' => 'Purchase Order', 'ReceivedQty' => 'Received Qty',
            'items.*.serial.*' => 'Serial No', 'items.*.qty' => 'Receiving Qty', 'items.*.startdate' => 'Start Date',
            'items.*.duration' => 'Duration', 'items.*.dtype' => 'Duration Type',
        ]);

        $order = PurchaseOrder::with('items.item')->findOrFail($data['POID']);
        
        abort_unless($request->user()->isSuperAdmin() || $order->unit_id === $request->user()->unit_id, 404);

        $lines = collect($data['items'])->filter(fn ($l) => ($l['qty'] ?? 0) > 0);
        $errors = [];
        if ($lines->isEmpty()) {
            $errors['Items'][] = 'Enter a receiving quantity for at least one item.';
        }
        if ($lines->sum('qty') !== (int) $data['ReceivedQty']) {
            $errors['ReceivedQty'][] = 'Received Qty must equal the total of the receiving quantities.';
        }
        foreach ($lines as $l) {
            $poLine = $order->items->firstWhere('id', $l['id']);
            if (! $poLine) {
                $errors['Items'][] = 'Item does not belong to this purchase order.';
                continue;
            }
            if ($l['qty'] > $poLine->dueQty()) {
                $errors['Items'][] = "{$poLine->item->code}: receiving quantity is more than the due quantity ({$poLine->dueQty()}).";
            }
            if (! $poLine->item->is_consumable && count($l['serial'] ?? []) !== (int) $l['qty']) {
                $errors['Items'][] = "{$poLine->item->code}: enter one serial number per received unit.";
            }
        }
        if ($errors) {
            return $this->fail('Validation failed.', $errors);
        }

        $receive = DB::transaction(function () use ($data, $order, $lines) {
            $receive = PurchaseReceive::create([
                'invoice_no' => $data['InvoiceNo'], 'date' => $data['Date'], 'unit_id' => $order->unit_id, 'supplier_id' => $order->supplier_id,
                'purchase_order_id' => $order->id, 'financial_year_id' => $order->financial_year_id, 'received_qty' => $data['ReceivedQty'],
            ]);
            // A Storeman's stock entry stays out of stock until the QM approves it.
            $stockStatus = $receive->isPending() ? Stock::PENDING : Stock::IN_STOCK;

            foreach ($lines as $l) {
                $poLine = $order->items->firstWhere('id', $l['id']);
                $rLine = $receive->items()->create(['purchase_order_item_id' => $poLine->id, 'item_id' => $poLine->item_id, 'quantity' => $l['qty']]);
                $poLine->increment('received_qty', $l['qty']);

                $coverage = $this->coverage($l, $poLine->item->has_warranty);
                $base = ['unit_id' => $order->unit_id, 'item_id' => $poLine->item_id, 'purchase_receive_id' => $receive->id,
                    'purchase_receive_item_id' => $rLine->id, 'supplier_id' => $order->supplier_id, 'status' => $stockStatus] + $coverage;

                if ($poLine->item->is_consumable) {
                    Stock::create($base + ['quantity' => $l['qty']]);
                } else {
                    foreach ($l['serial'] as $serial) {
                        Stock::create($base + ['serial_no' => trim($serial), 'quantity' => 1]);
                    }
                }
            }

            return $receive;
        });

        $message = $receive->isPending() ? 'Stock entry submitted for QM approval.' : 'Purchase Order received successfully.';

        return $this->ok($message, ['redirect' => route('inventory.purchase.purchaseorderreceive.show', $receive)]);
    }

    public function show(Request $request, PurchaseReceive $purchaseorderreceive): View
    {
        $this->authorizeUnit($request, $purchaseorderreceive);

        return view('inventory.purchase.receives.show', ['receive' => $purchaseorderreceive->load(self::DETAIL)]);
    }

    public function pdf(Request $request, PurchaseReceive $purchaseorderreceive): Response
    {
        $this->authorizeUnit($request, $purchaseorderreceive);

        return Pdf::stream('pdf.purchase-receive', ['receive' => $purchaseorderreceive->load(self::DETAIL)], 'Receive Purchase Order Details', 'receive-'.$purchaseorderreceive->id);
    }

    public function edit(Request $request, PurchaseReceive $purchaseorderreceive): View
    {
        $this->authorizeUnit($request, $purchaseorderreceive);

        return view('inventory.purchase.receives.edit', ['receive' => $purchaseorderreceive->load(self::DETAIL)]);
    }

    /**
     * formNo 1 = header + serial numbers, 2 = warranty info of one stock row.
     */
    public function update(Request $request, PurchaseReceive $purchaseorderreceive): JsonResponse
    {
        $this->authorizeUnit($request, $purchaseorderreceive);

        if ((int) $request->input('formNo') === 2) {
            $stock = $purchaseorderreceive->stocks()->findOrFail($request->input('wid'));
            $data = $this->check($request, [
                'Type' => ['required', Rule::in(['Warranty', 'Service'])],
                'StartDate' => ['required', 'date'],
                'Duration' => ['required', 'integer', 'min:1'],
                'DurationType' => ['required', Rule::in(['Days', 'Months', 'Years'])],
                'Terms' => ['nullable', 'string', 'max:1000'],
            ], ['StartDate' => 'Start Date', 'DurationType' => 'Duration Type']);
            $stock->update($this->coverage(['type' => $data['Type'], 'startdate' => $data['StartDate'], 'duration' => $data['Duration'], 'dtype' => $data['DurationType'], 'terms' => $data['Terms'] ?? null], true));

            return $this->ok('Warranty information updated successfully.');
        }

        $data = $this->check($request, [
            'Date' => ['required', 'date'],
            'InvoiceNo' => ['required', 'string', 'max:100'],
            'items' => ['nullable', 'array'],
            'items.*.rid' => ['required', 'integer'],
            'items.*.serial' => ['required', 'string', 'min:3', 'max:100', 'distinct'],
        ], ['InvoiceNo' => 'Invoice No', 'items.*.serial' => 'Serial No']);

        foreach ($data['items'] ?? [] as $row) {
            if (Stock::where('serial_no', $row['serial'])->where('id', '!=', $row['rid'])->exists()) {
                return $this->fail('Validation failed.', ['Serial No' => ["Serial No {$row['serial']} already exists!"]]);
            }
        }

        DB::transaction(function () use ($purchaseorderreceive, $data) {
            $purchaseorderreceive->update(['date' => $data['Date'], 'invoice_no' => $data['InvoiceNo']]);
            foreach ($data['items'] ?? [] as $row) {
                $purchaseorderreceive->stocks()->whereKey($row['rid'])->whereNotNull('serial_no')->update(['serial_no' => trim($row['serial'])]);
            }
        });

        return $this->ok('Purchase Order Receive updated successfully.', ['redirect' => route('inventory.purchase.purchaseorderreceive.show', $purchaseorderreceive)]);
    }

    public function destroy(Request $request, PurchaseReceive $purchaseorderreceive): JsonResponse
    {
        $this->authorizeUnit($request, $purchaseorderreceive);
        $receive = $purchaseorderreceive->load(['items.orderItem', 'stocks']);

        // Only while nothing received has moved on (issued, deployed, damaged...).
        if ($receive->stocks->contains(fn ($s) => ! in_array($s->status, [Stock::IN_STOCK, Stock::PENDING], true) || $s->unit_id !== $receive->unit_id)
            || Stock::whereIn('parent_id', $receive->stocks->pluck('id'))->exists()) {
            return $this->fail('Received items are already in use (issued/deployed/damaged); this receive can not be deleted.');
        }

        DB::transaction(function () use ($receive) {
            // A rejected entry already gave its quantity back to the PO.
            foreach ($receive->approval_status === PurchaseReceive::REJECTED ? [] : $receive->items as $line) {
                $line->orderItem?->decrement('received_qty', $line->quantity);
            }
            $receive->stocks()->delete();
            $receive->delete();
        });

        return $this->ok('Purchase Order Receive deleted successfully.', ['id' => $receive->id]);
    }

    private function coverage(array $l, bool $hasWarranty): array
    {
        if (! $hasWarranty || empty($l['type'])) {
            return ['coverage_type' => null, 'coverage_start' => null, 'duration' => null, 'duration_type' => null, 'coverage_end' => null, 'coverage_terms' => null];
        }

        return [
            'coverage_type' => $l['type'], 'coverage_start' => $l['startdate'], 'duration' => $l['duration'], 'duration_type' => $l['dtype'],
            'coverage_end' => Stock::coverageEnd($l['startdate'], (int) $l['duration'], $l['dtype']), 'coverage_terms' => $l['terms'] ?? null,
        ];
    }

    private function openOrders(Request $request)
    {
        return PurchaseOrder::with('items')
            ->where('status', true)
            ->approved()
            ->when(! $request->user()->isSuperAdmin(), fn ($q) => $q->where('unit_id', $request->user()->unit_id))
            ->latest('id')
            ->get()
            ->filter(fn ($o) => $o->dueQty() > 0)
            ->pluck('po_no', 'id');
    }

    private function authorizeUnit(Request $request, PurchaseReceive $receive): void
    {
        abort_unless($request->user()->isSuperAdmin() || $receive->unit_id === $request->user()->unit_id, 404);
    }

    /** The AJAX helpers (outside the menu guard) are for those who may receive or edit receives. */
    private function canReceive(Request $request): bool
    {
        return $request->user()->canMenu('inventory/purchase/purchaseorderreceive', 'create')
            || $request->user()->canMenu('inventory/purchase/purchaseorderreceive', 'edit');
    }
}
