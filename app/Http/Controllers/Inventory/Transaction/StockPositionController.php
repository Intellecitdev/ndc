<?php

namespace App\Http\Controllers\Inventory\Transaction;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Concerns\ScopesUnit;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Deployment;
use App\Models\IssueVoucher;
use App\Models\Stock;
use App\Models\Unit;
use App\Support\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Stock Position: the wing's stock register, deployment of stock to personnel,
 * and issuing stock to other wings (Issue Voucher).
 */
class StockPositionController extends Controller
{
    use JsonResponses, ScopesUnit;

    public function index(Request $request): View
    {
        $status = Stock::TYPES[(int) $request->TypeID] ?? Stock::IN_STOCK;

        return view('inventory.transaction.stockposition.index', [
            'stocks' => $this->filtered($request)->where('stocks.status', $status)->latest('stocks.id')->paginate(15)->withQueryString(),
            'categories' => Category::active()->orderBy('name')->pluck('name', 'id'),
            'units' => Unit::where('status', true)->orderBy('order')->pluck('name', 'id'),
        ]);
    }

    /** Issue Voucher page: pick in-stock rows and the wing each goes to. */
    public function create(Request $request): View
    {
        return view('inventory.transaction.stockposition.create', [
            'stocks' => $this->filtered($request)->inStock()->latest('stocks.id')->paginate(15)->withQueryString(),
            'categories' => Category::active()->orderBy('name')->pluck('name', 'id'),
            'wings' => Unit::where('status', true)->where('id', '!=', $request->user()->unit_id)->orderBy('order')->pluck('name', 'id'),
        ]);
    }

    /** Barcode scan on the issue page: the in-stock row whose label (serial, or item code for consumables) is the scanned code. */
    public function scan(Request $request): JsonResponse
    {
        $code = trim((string) $request->code);
        $stock = $code === '' ? null : $this->scopeUnit(Stock::query()->with(['item.category', 'item.unit']), $request, 'stocks.unit_id')->inStock()
            ->where(fn ($q) => $q->where('serial_no', $code)->orWhere(fn ($q) => $q->whereNull('serial_no')->whereHas('item', fn ($q) => $q->where('code', $code))))
            ->whereNotIn('stocks.id', (array) $request->input('except', []))
            ->oldest('stocks.id')->first();

        if (! $stock) {
            return $this->fail("No in-stock product found for \"{$code}\".");
        }

        return $this->ok("{$stock->label()} added to the list.", ['row' => [
            'rid' => $stock->id, 'serial' => $stock->label(), 'name' => $stock->item->name, 'category' => $stock->item->category?->name,
            'quantity' => $stock->quantity, 'unit' => $stock->item->unit?->name,
        ]]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->check($request, [
            'items' => ['required', 'array', 'min:1'],
            'items.*.rid' => ['required', 'distinct', 'exists:stocks,id'],
            'items.*.unitid' => ['required', Rule::exists('units', 'id')->where('status', true)],
        ], ['items' => 'Items', 'items.*.unitid' => 'To Wing']);

        $stocks = Stock::whereIn('id', collect($data['items'])->pluck('rid'))->get()->keyBy('id');
        foreach ($data['items'] as $line) {
            $stock = $stocks[$line['rid']];
            if ($stock->status !== Stock::IN_STOCK || ! $this->ownsUnit($request, $stock->unit_id)) {
                return $this->fail("{$stock->label()} is not in your stock any more.");
            }
            if ((int) $line['unitid'] === $stock->unit_id) {
                return $this->fail("{$stock->label()}: choose another wing to issue to.");
            }
        }

        $voucher = DB::transaction(function () use ($data, $stocks, $request) {
            $voucher = IssueVoucher::create(['iv_no' => uniqid('tmp'), 'date' => now(), 'from_unit_id' => $request->user()->unit_id]);
            $voucher->update(['iv_no' => IssueVoucher::makeNumber($voucher->id)]);
            foreach ($data['items'] as $line) {
                $stock = $stocks[$line['rid']];
                $voucher->items()->create(['stock_id' => $stock->id, 'to_unit_id' => $line['unitid'], 'quantity' => $stock->quantity]);
                $stock->update(['status' => Stock::TRANSFERRED]);
            }

            return $voucher;
        });

        // A Storeman's voucher reaches the receiving wings once the QM approves it.
        if ($voucher->isPending()) {
            return $this->ok('Issue Voucher submitted for QM approval.', ['redirect' => route('inventory.transaction.issuevouchers.index')]);
        }
        $voucher->notifyReceivers();

        return $this->ok('Issue Voucher created successfully.', ['redirect' => route('inventory.transaction.issuevouchers.index')]);
    }

    /** Deploy to personnel (licence details for licence items). */
    public function update(Request $request, Stock $stockposition): JsonResponse
    {
        $stock = $stockposition->load('item');
        abort_unless($this->ownsUnit($request, $stock->unit_id), 404);
        if (! $stock->canDeploy()) {
            return $this->fail('Only items received by your wing can be deployed.');
        }

        $license = $stock->item->is_license;
        $data = $this->check($request, [
            'Quantity' => ['required', 'integer', 'min:1', 'max:'.$stock->quantity],
            'Unit' => ['required', 'exists:units,id'],
            'DeployDate' => ['required', 'date'],
            'Personnel' => ['required', 'string', 'max:150'],
            'Comments' => ['nullable', 'string', 'max:250'],
            'ProductKey' => [Rule::requiredIf($license), 'nullable', 'string', 'max:100'],
            'ManufacturerName' => [Rule::requiredIf($license), 'nullable', 'string', 'max:100'],
            'LicensedToName' => [Rule::requiredIf($license), 'nullable', 'string', 'max:100'],
            'LicensedToEmail' => [Rule::requiredIf($license), 'nullable', 'email', 'max:100'],
            'ReAssignable' => [Rule::requiredIf($license), 'nullable', 'boolean'],
            'PurchaseDate' => [Rule::requiredIf($license), 'nullable', 'date'],
            'ExpirationDate' => [Rule::requiredIf($license), 'nullable', 'date', 'after_or_equal:PurchaseDate'],
            'Note' => ['nullable', 'string', 'max:250'],
        ], [
            'Quantity' => 'Deploy Quantity', 'Unit' => 'Unit Name', 'DeployDate' => 'Deploy Date', 'Personnel' => 'Assigned Personnel',
            'ProductKey' => 'Product Key', 'ManufacturerName' => 'Manufacturer Name', 'LicensedToName' => 'Licensed To Name',
            'LicensedToEmail' => 'Licensed To Email', 'ReAssignable' => 'Renewable ?', 'PurchaseDate' => 'Purchase Date', 'ExpirationDate' => 'Expiration Date',
        ]);

        DB::transaction(function () use ($stock, $data, $license) {
            $deployed = $stock->take((int) $data['Quantity'], Stock::DEPLOYED);
            $deployment = Deployment::create([
                'stock_id' => $deployed->id, 'unit_id' => $data['Unit'], 'quantity' => $data['Quantity'],
                'deploy_date' => $data['DeployDate'], 'personnel' => $data['Personnel'], 'comments' => $data['Comments'] ?? null,
            ]);
            if ($license) {
                $deployment->license()->create([
                    'stock_id' => $deployed->id, 'product_key' => $data['ProductKey'], 'manufacturer' => $data['ManufacturerName'],
                    'licensed_to_name' => $data['LicensedToName'], 'licensed_to_email' => $data['LicensedToEmail'],
                    're_assignable' => (bool) $data['ReAssignable'], 'purchase_date' => $data['PurchaseDate'],
                    'expiration_date' => $data['ExpirationDate'], 'note' => $data['Note'] ?? null,
                ]);
            }
        });

        return $this->ok('Stock deployed successfully.');
    }

    /** "Item Delete": remove a stock row that has not been used anywhere. */
    public function destroy(Request $request, Stock $stockposition): JsonResponse
    {
        abort_unless($this->ownsUnit($request, $stockposition->unit_id), 404);
        if ($stockposition->status !== Stock::IN_STOCK) {
            return $this->fail('Only items in stock can be deleted.');
        }
        try {
            DB::transaction(function () use ($stockposition) {
                $stockposition->purchaseReceiveItem?->decrement('quantity', $stockposition->quantity);
                $stockposition->purchaseReceiveItem?->orderItem?->decrement('received_qty', $stockposition->quantity);
                $stockposition->purchaseReceive?->decrement('received_qty', $stockposition->quantity);
                $stockposition->delete();
            });
        } catch (\Illuminate\Database\QueryException) {
            return $this->fail('This item has transactions and can not be deleted.');
        }

        return $this->ok('Item deleted successfully.', ['id' => $stockposition->id]);
    }

    /** Delivery Challan of an issue voucher. */
    public function pdf(Request $request, IssueVoucher $voucher): Response
    {
        abort_unless($this->ownsUnit($request, $voucher->from_unit_id), 404);
        $voucher->load(['fromUnit', 'creator.rank', 'items.stock.item.category', 'items.stock.item.unit', 'items.toUnit']);

        return Pdf::stream('pdf.delivery-challan', ['voucher' => $voucher], 'Delivery Challan', $voucher->iv_no);
    }

    private function filtered(Request $request)
    {
        return $this->scopeUnit(Stock::query()->with(['item.category', 'item.productModel', 'item.unit', 'creator', 'supplier', 'purchaseReceive']), $request, 'stocks.unit_id')
            ->when($request->filled('Serial'), fn ($q) => $q->where('serial_no', 'like', "%{$request->Serial}%"))
            ->when($request->filled('Name'), fn ($q) => $q->whereHas('item', fn ($q) => $q->where('name', 'like', "%{$request->Name}%")))
            ->when($request->filled('CategoryID'), fn ($q) => $q->whereHas('item', fn ($q) => $q->where('category_id', $request->CategoryID)));
    }
}
