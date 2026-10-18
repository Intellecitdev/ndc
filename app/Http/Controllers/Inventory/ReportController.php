<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Concerns\ScopesUnit;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Damage;
use App\Models\IssueVoucherItem;
use App\Models\Item;
use App\Models\License;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\WarrantyClaim;
use App\Support\Excel;
use App\Support\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * Inventory > Reports. Every report has the same flow as the reference:
 * filter form + "View Mode" (0 = Web View, 1 = PDF View, 2 = Excel View).
 */
class ReportController extends Controller
{
    use ScopesUnit;

    private const VIEWS = [0 => 'Web View', 1 => 'PDF View', 2 => 'Excel View'];

    public function itemsearch(Request $r)
    {
        return $this->render($r, 'Item Search Reports', [
            'Serial' => ['text', 'Serial No'], 'Name' => ['text', 'Item Name'], 'CategoryID' => ['select', 'Category', $this->categories()],
        ], function () use ($r) {
            $stocks = $this->stocks($r)->with(['unit', 'supplier', 'purchaseReceive.financialYear', 'item.unit', 'item.productModel'])->orderBy('stocks.id')->get();

            return [
                ['SL', 'PO Rcv Date', 'Purchase By', 'Item Serial No', 'Item Name', 'Category', 'Quantity', 'Supplier', 'Status', 'Coverage', 'Date(From)', 'Date(To)', 'Fin. Year'],
                $stocks->values()->map(fn ($s, $i) => [
                    $i + 1, $s->purchaseReceive?->date->format('d-m-Y'), $s->unit?->name, $s->label(), $s->item->name, $s->item->category?->name,
                    $s->quantity.' '.$s->item->unit?->code, $s->supplier?->name, $s->status, $s->coverage_type,
                    $s->coverage_start?->format('d-m-Y'), $s->coverage_end?->format('d-m-Y'), $s->purchaseReceive?->financialYear?->name,
                ])->all(),
                ['details' => $stocks->values()->map->details()->all()],
            ];
        });
    }

    public function purchasereport(Request $r)
    {
        return $this->render($r, 'Purchase Reports', [
            'Serial' => ['text', 'Serial No'], 'Name' => ['text', 'Item Name'], 'FromDate' => ['date', 'From Date'], 'ToDate' => ['date', 'To Date'],
            'PONo' => ['text', 'PO No'], 'SupplierID' => ['select', 'Supplier', Supplier::orderBy('name')->pluck('name', 'id')],
            'CategoryID' => ['select', 'Category Name', $this->categories()],
        ], function () use ($r) {
            $stocks = $this->stocks($r)->whereNotNull('purchase_receive_id')->whereNull('parent_id')
                ->with(['unit', 'supplier', 'purchaseReceive.purchaseOrder', 'item.brand', 'item.productModel', 'item.unit'])
                ->when($r->filled('PONo'), fn ($q) => $q->whereHas('purchaseReceive.purchaseOrder', fn ($q) => $q->where('po_no', 'like', "%{$r->PONo}%")))
                ->when($r->filled('SupplierID'), fn ($q) => $q->where('supplier_id', $r->SupplierID))
                ->when($r->filled('FromDate'), fn ($q) => $q->whereHas('purchaseReceive.purchaseOrder', fn ($q) => $q->whereDate('date', '>=', $r->FromDate)))
                ->when($r->filled('ToDate'), fn ($q) => $q->whereHas('purchaseReceive.purchaseOrder', fn ($q) => $q->whereDate('date', '<=', $r->ToDate)))
                ->orderBy('stocks.id')->get();

            return [
                ['SL', 'PO No', 'PO Date', 'Purchase By', 'Item Serial No', 'Item Name', 'Category', 'Brand', 'Model', 'Quantity', 'Store In', 'Supplier', 'Status'],
                $stocks->values()->map(fn ($s, $i) => [
                    $i + 1, $s->purchaseReceive?->purchaseOrder?->po_no, $s->purchaseReceive?->purchaseOrder?->date->format('d-m-Y'), $s->unit?->name,
                    $s->label(), $s->item->name, $s->item->category?->name, $s->item->brand?->name, $s->item->productModel?->name,
                    $s->quantity.' '.$s->item->unit?->code, $s->purchaseReceive?->date->format('d-m-Y'), $s->supplier?->name, $s->status,
                ])->all(),
            ];
        });
    }

    public function issuereport(Request $r)
    {
        return $this->render($r, 'Issue Reports', [
            'Serial' => ['text', 'Serial No'], 'Name' => ['text', 'Item Name'], 'FromDate' => ['date', 'From Date'], 'ToDate' => ['date', 'To Date'],
            'Code' => ['text', 'Issue Voucher No'], 'UnitID' => ['select', 'Wing', Unit::orderBy('order')->pluck('name', 'id')],
            'CategoryID' => ['select', 'Category Name', $this->categories()],
        ], function () use ($r) {
            $rows = IssueVoucherItem::with(['voucher', 'toUnit', 'stock.item.brand', 'stock.item.productModel', 'stock.item.category', 'stock.item.unit'])
                ->whereHas('voucher', fn ($q) => $this->scopeUnit($q, $r, 'from_unit_id')
                    ->when($r->filled('Code'), fn ($q) => $q->where('iv_no', 'like', "%{$r->Code}%"))
                    ->when($r->filled('FromDate'), fn ($q) => $q->whereDate('date', '>=', $r->FromDate))
                    ->when($r->filled('ToDate'), fn ($q) => $q->whereDate('date', '<=', $r->ToDate)))
                ->when($r->filled('UnitID'), fn ($q) => $q->where('to_unit_id', $r->UnitID))
                ->whereHas('stock', fn ($q) => $this->itemFilters($q, $r))
                ->orderBy('id')->get();

            return [
                ['SL', 'IV No', 'Issue Date', 'Item Serial No', 'Item Name', 'Category', 'Brand', 'Model', 'Quantity', 'Issued To', 'Status'],
                $rows->values()->map(fn ($l, $i) => [
                    $i + 1, $l->voucher->iv_no, $l->voucher->date->format('d-m-Y'), $l->stock->label(), $l->stock->item->name, $l->stock->item->category?->name,
                    $l->stock->item->brand?->name, $l->stock->item->productModel?->name, $l->quantity.' '.$l->stock->item->unit?->name, $l->toUnit?->name, $l->status,
                ])->all(),
            ];
        });
    }

    public function damagereport(Request $r)
    {
        return $this->render($r, 'Damage Reports', [
            'Serial' => ['text', 'Serial No'], 'Name' => ['text', 'Item Name'], 'FromDate' => ['date', 'From Date'], 'ToDate' => ['date', 'To Date'],
            'CategoryID' => ['select', 'Category Name', $this->categories()],
        ], function () use ($r) {
            $rows = $this->scopeUnit(Damage::query(), $r)->with(['stock.item.category', 'stock.item.unit', 'creator', 'claim'])
                ->whereHas('stock', fn ($q) => $this->itemFilters($q, $r))
                ->when($r->filled('FromDate'), fn ($q) => $q->whereDate('date', '>=', $r->FromDate))
                ->when($r->filled('ToDate'), fn ($q) => $q->whereDate('date', '<=', $r->ToDate))
                ->orderBy('id')->get();

            return [
                ['SL', 'Damage Date', 'Item Serial No', 'Item Name', 'Category', 'Quantity', 'Reason', 'Taken Actions', 'Declare By', 'Status'],
                $rows->values()->map(fn ($d, $i) => [
                    $i + 1, $d->date->format('d-m-Y'), $d->stock->label(), $d->stock->item->name, $d->stock->item->category?->name,
                    $d->quantity.' '.$d->stock->item->unit?->code, $d->reason, $d->actions, $d->creator?->full_name,
                    $d->status.($d->claim ? " ({$d->claim->type}: {$d->claim->status})" : ''),
                ])->all(),
            ];
        });
    }

    public function stockbalancereport(Request $r)
    {
        return $this->render($r, 'Stock Balance Report', [
            'Serial' => ['text', 'Serial No'], 'Name' => ['text', 'Item Name'], 'FromDate' => ['date', 'From Date'], 'ToDate' => ['date', 'To Date'],
            'CategoryID' => ['select', 'Category Name', $this->categories()], 'UnitID' => ['select', 'Wing', $this->wings($r), false],
        ], function () use ($r) {
            $stocks = $this->stocks($r)->inStock()->with(['item.unit', 'purchaseReceive'])
                ->when($r->filled('FromDate'), fn ($q) => $q->whereDate('stocks.created_at', '>=', $r->FromDate))
                ->when($r->filled('ToDate'), fn ($q) => $q->whereDate('stocks.created_at', '<=', $r->ToDate))
                ->orderBy('item_id')->orderBy('stocks.id')->get();

            return [
                ['SL', 'Item Serial No', 'Item Name', 'Category', 'Quantity', 'A/U', 'Store In', 'Status'],
                $stocks->values()->map(fn ($s, $i) => [
                    $i + 1, $s->label(), $s->item->name, $s->item->category?->name, $s->quantity, $s->item->unit?->code,
                    ($s->purchaseReceive?->date ?? $s->created_at)->format('d-M-Y'), $s->status,
                ])->all(),
            ];
        }, alwaysRun: true);
    }

    public function warrantyinformation(Request $r)
    {
        return $this->render($r, 'Warranty Information Reports', [
            'Serial' => ['text', 'Serial No'], 'Name' => ['text', 'Item Name'], 'FromDate' => ['date', 'From Date'], 'ToDate' => ['date', 'To Date'],
            'CategoryID' => ['select', 'Category Name', $this->categories()], 'UnitID' => ['select', 'Wing', $this->wings($r), false],
            'TypeID' => ['select', 'Type', [1 => 'Warranty Info', 2 => 'Claim Warranty', 3 => 'Receive Warranty'], true, true],
        ], function () use ($r) {
            if ((int) $r->TypeID === 1) {
                $stocks = $this->stocks($r)->whereNotNull('coverage_type')->with(['supplier'])
                    ->when($r->filled('FromDate'), fn ($q) => $q->whereDate('coverage_start', '>=', $r->FromDate))
                    ->when($r->filled('ToDate'), fn ($q) => $q->whereDate('coverage_end', '<=', $r->ToDate))
                    ->orderBy('stocks.id')->get();

                return [
                    ['SL', 'Item Serial No', 'Item Name', 'Category', 'Coverage', 'Duration', 'Start Date', 'End Date', 'Terms', 'Supplier', 'Expires In'],
                    $stocks->values()->map(fn ($s, $i) => [
                        $i + 1, $s->label(), $s->item->name, $s->item->category?->name, $s->coverage_type, $s->duration.' '.$s->duration_type,
                        $s->coverage_start?->format('d-m-Y'), $s->coverage_end?->format('d-m-Y'), $s->coverage_terms, $s->supplier?->name,
                        $s->coverage_end ? ($s->coverage_end->isPast() ? 'Expired' : $s->coverage_end->diffForHumans(now(), ['parts' => 1])) : '',
                    ])->all(),
                ];
            }

            $received = (int) $r->TypeID === 3;
            $claims = $this->scopeUnit(WarrantyClaim::query(), $r)->with(['stock.item.category', 'claimer', 'stock.supplier'])
                ->whereIn('status', $received ? ['Received', 'Not Covered'] : ['For Claim', 'Claimed'])
                ->whereHas('stock', fn ($q) => $this->itemFilters($q, $r))
                ->when($r->filled('FromDate'), fn ($q) => $q->whereDate('created_at', '>=', $r->FromDate))
                ->when($r->filled('ToDate'), fn ($q) => $q->whereDate('created_at', '<=', $r->ToDate))
                ->orderBy('id')->get();

            return [
                $received
                    ? ['SL', 'Item Serial No', 'Item Name', 'Category', 'Type', 'Claim Date', 'Received At', 'Result', 'Supplier']
                    : ['SL', 'Item Serial No', 'Item Name', 'Category', 'Type', 'Claim Date', 'Expected Return', 'Comments', 'Claimed By', 'Status'],
                $claims->values()->map(fn ($c, $i) => $received
                    ? [$i + 1, $c->stock->label(), $c->stock->item->name, $c->stock->item->category?->name, $c->type, $c->claim_date?->format('d-m-Y'),
                        $c->received_at?->format('d-m-Y'), WarrantyClaim::RECEIVE_STATUSES[$c->status] ?? $c->status, $c->stock->supplier?->name]
                    : [$i + 1, $c->stock->label(), $c->stock->item->name, $c->stock->item->category?->name, $c->type, $c->claim_date?->format('d-m-Y'),
                        $c->expected_return_date?->format('d-m-Y'), $c->comments, $c->claimer?->full_name, $c->status])->all(),
            ];
        }, alwaysRun: true);
    }

    public function licensesinformation(Request $r)
    {
        return $this->render($r, 'License Information Reports', [
            'Serial' => ['text', 'Product Key'], 'Name' => ['text', 'Item Name'], 'FromDate' => ['date', 'From Date'], 'ToDate' => ['date', 'To Date'],
            'CategoryID' => ['select', 'Category Name', $this->categories()], 'UnitID' => ['select', 'Wing', $this->wings($r), false],
            'SupID' => ['select', 'Supplier', Supplier::orderBy('name')->pluck('name', 'id')],
        ], function () use ($r) {
            $rows = License::with(['stock.item', 'stock.supplier', 'deployment.unit'])
                ->whereHas('stock', function ($q) use ($r) {
                    $this->scopeUnit($q, $r);
                    $q->when($r->filled('UnitID') && $r->user()->isSuperAdmin(), fn ($q) => $q->where('unit_id', $r->UnitID))
                        ->when($r->filled('SupID'), fn ($q) => $q->where('supplier_id', $r->SupID))
                        ->whereHas('item', fn ($q) => $q
                            ->when($r->filled('Name'), fn ($q) => $q->where('name', 'like', "%{$r->Name}%"))
                            ->when($r->filled('CategoryID'), fn ($q) => $q->where('category_id', $r->CategoryID)));
                })
                ->when($r->filled('Serial'), fn ($q) => $q->where('product_key', 'like', "%{$r->Serial}%"))
                ->when($r->filled('FromDate'), fn ($q) => $q->whereDate('purchase_date', '>=', $r->FromDate))
                ->when($r->filled('ToDate'), fn ($q) => $q->whereDate('purchase_date', '<=', $r->ToDate))
                ->orderBy('id')->get();

            return [
                ['SL', 'Item Name', 'Product Key', 'Manufacturer', 'Licensed To Name', 'Licensed To Email', 'Purchase Date', 'Expiration Date', 'Deployed To', 'Supplier', 'Expires In'],
                $rows->values()->map(fn ($l, $i) => [
                    $i + 1, $l->stock->item->name, $l->product_key, $l->manufacturer, $l->licensed_to_name, $l->licensed_to_email,
                    $l->purchase_date->format('d-m-Y'), $l->expiration_date->format('d-m-Y'),
                    $l->deployment?->personnel.' ('.$l->deployment?->unit?->name.')', $l->stock->supplier?->name,
                    $l->expiration_date->isPast() ? 'Expired' : $l->expiration_date->diffForHumans(now(), ['parts' => 1]),
                ])->all(),
            ];
        }, alwaysRun: true);
    }

    public function stockchecking(Request $r)
    {
        $stocks = $this->scopeUnit(Stock::query()->with('item'), $r)->orderBy('serial_no')->get()
            ->mapWithKeys(fn ($s) => [$s->id => $s->label().' : '.$s->item->name]);

        return $this->render($r, 'Stock Checking Report', [
            'RegsID' => ['select', 'Item (Serial No : Name)', $stocks, true, true],
            'UnitID' => ['select', 'Wing', $this->wings($r), false, true],
        ], function () use ($r) {
            $stock = $this->scopeUnit(Stock::query(), $r)->with(['item.category', 'item.unit', 'unit', 'purchaseReceive', 'deployments.unit'])->find($r->RegsID);
            if (! $stock) {
                return [[], []];
            }
            $issued = IssueVoucherItem::with(['voucher.fromUnit', 'toUnit', 'actioner'])->where('stock_id', $stock->id)->get();
            $damages = Damage::with(['creator', 'claim'])->where('stock_id', $stock->id)->get();
            $children = Stock::where('parent_id', $stock->id)->get();
            $received = $stock->quantity + $children->sum('quantity');

            $history = collect()
                ->concat($issued->map(fn ($l) => [$l->created_at, 'Issue Voucher '.$l->voucher->iv_no, $l->quantity, $l->voucher->fromUnit?->name.' → '.$l->toUnit?->name, $l->status]))
                ->concat($stock->deployments->map(fn ($d) => [$d->created_at, 'Deployment', $d->quantity, $d->personnel.' ('.$d->unit?->name.')', 'Deployed']))
                ->concat($damages->map(fn ($d) => [$d->created_at, 'Damage', $d->quantity, $d->reason, $d->status.($d->claim ? ' / '.$d->claim->type.' '.$d->claim->status : '')]))
                ->concat($children->map(fn ($c) => [$c->created_at, 'Split', $c->quantity, '', $c->status]))
                ->sortBy(fn ($h) => $h[0])->values();

            return [
                ['Date', 'Transaction', 'Quantity', 'Details', 'Status'],
                $history->map(fn ($h) => [Carbon::parse($h[0])->format('d-m-Y h:i A'), $h[1], $h[2], $h[3], $h[4]])->all(),
                [
                    'register' => [
                        ['Item Serial No', 'Item Name', 'Category', 'Quantity', 'Receive At', 'Store In', 'Status'],
                        [$stock->label(), $stock->item->name, $stock->item->category?->name, $received.' '.$stock->item->unit?->code,
                            ($stock->purchaseReceive?->date ?? $stock->created_at)->format('d-M-Y'), $stock->unit?->name, $stock->status],
                    ],
                    'summary' => [
                        ['Receive Quantity', 'Transaction Quantity', 'Stock Quantity', '#of Records'],
                        [$received, $received - ($stock->status === Stock::IN_STOCK ? $stock->quantity : 0), $stock->status === Stock::IN_STOCK ? $stock->quantity : 0, $history->count() + 1],
                    ],
                ],
            ];
        }, views: [0 => 'Web View', 1 => 'PDF View']);
    }

    public function stocksummary(Request $r)
    {
        $items = Item::whereIn('id', $this->scopeUnit(Stock::query(), $r)->select('item_id'))->orderBy('code')->get()
            ->mapWithKeys(fn ($i) => [$i->id => $i->code.' : '.$i->name]);

        return $this->render($r, 'Stock Summary Report', [
            'ItemID' => ['select', 'Item (Code : Name)', $items],
            'UnitID' => ['select', 'Wing', $this->wings($r), false],
            'TypeID' => ['select', 'Stock Status', [0 => 'All', 1 => 'Out of Stock', 2 => 'In Stock'], false, true],
        ], function () use ($r) {
            $stocks = $this->scopeUnit(Stock::query(), $r)->with('item.category')
                ->when($r->filled('ItemID'), fn ($q) => $q->where('item_id', $r->ItemID))->get();
            $issued = IssueVoucherItem::whereIn('stock_id', $stocks->pluck('id'))->where('status', '!=', 'Returned')->get()->groupBy(fn ($l) => $stocks->firstWhere('id', $l->stock_id)?->item_id);

            $rows = $stocks->groupBy('item_id')->map(function ($group) use ($issued) {
                $item = $group->first()->item;
                $receive = $group->whereNull('parent_id')->sum('quantity') + $group->whereNotNull('parent_id')->sum('quantity');
                $inStock = $group->where('status', Stock::IN_STOCK)->sum('quantity');

                return [$item->code, $item->name, $item->category?->name, $receive, ($issued[$item->id] ?? collect())->sum('quantity'),
                    $group->where('status', Stock::DAMAGE)->sum('quantity'), $inStock];
            })->filter(fn ($row) => match ((int) request('TypeID')) {
                1 => $row[6] === 0,
                2 => $row[6] > 0,
                default => true,
            })->sortBy(0)->values();

            return [
                ['SL', 'Item Code', 'Item Name', 'Category', 'Receive Qty', 'Issue Qty', 'Damage Qty', 'In Stock Qty'],
                $rows->map(fn ($row, $i) => array_merge([$i + 1], $row))->all(),
            ];
        }, alwaysRun: true);
    }

    // ------------------------------------------------------------------

    /**
     * @param  array  $filters  name => [type, label, options?, placeholder? (default true), required? (default false)]
     * @param  callable  $build  returns [columns, rows, extra?]
     */
    private function render(Request $r, string $title, array $filters, callable $build, bool $alwaysRun = false, array $views = self::VIEWS)
    {
        $page = $r->segment(3);
        $submitted = $r->has('ViewID');
        $hasFilter = collect($filters)->keys()->reject(fn ($k) => in_array($k, ['UnitID', 'TypeID'], true))->contains(fn ($k) => $r->filled($k));

        [$columns, $rows, $extra] = ($submitted && ($alwaysRun || $hasFilter)) ? $build() + [2 => []] : [[], [], []];

        $view = (int) $r->input('ViewID', 0);
        if ($submitted && $view === 1) {
            return Pdf::stream('pdf.report', compact('columns', 'rows', 'extra'), $title, $title, count($columns) > 9 ? 'landscape' : 'portrait');
        }
        if ($submitted && $view === 2 && isset($views[2])) {
            return Excel::download($title, $columns, $rows);
        }

        return view('inventory.reports.show', compact('title', 'filters', 'columns', 'rows', 'extra', 'submitted', 'hasFilter', 'alwaysRun', 'views', 'page'));
    }

    /** Stocks of the user's wing (or the chosen wing for Super Admin) with the common item filters. */
    private function stocks(Request $r): Builder
    {
        $q = $this->scopeUnit(Stock::query()->with('item.category'), $r, 'stocks.unit_id')
            ->when($r->filled('UnitID') && $r->user()->isSuperAdmin(), fn ($q) => $q->where('stocks.unit_id', $r->UnitID));

        return $this->itemFilters($q, $r);
    }

    private function itemFilters($q, Request $r)
    {
        return $q->when($r->filled('Serial'), fn ($q) => $q->where('serial_no', 'like', "%{$r->Serial}%"))
            ->when($r->filled('Name'), fn ($q) => $q->whereHas('item', fn ($q) => $q->where('name', 'like', "%{$r->Name}%")))
            ->when($r->filled('CategoryID'), fn ($q) => $q->whereHas('item', fn ($q) => $q->where('category_id', $r->CategoryID)));
    }

    private function categories()
    {
        return Category::orderBy('name')->pluck('name', 'id');
    }

    private function wings(Request $r)
    {
        return $r->user()->isSuperAdmin() ? Unit::orderBy('order')->pluck('name', 'id') : Unit::whereKey($r->user()->unit_id)->pluck('name', 'id');
    }
}
