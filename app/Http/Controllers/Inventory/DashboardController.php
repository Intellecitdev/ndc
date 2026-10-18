<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Damage;
use App\Models\IssueVoucher;
use App\Models\License;
use App\Models\PurchaseOrder;
use App\Models\Stock;
use App\Models\WarrantyClaim;
use App\Models\Item;
use App\Models\ItemUnit;
use App\Models\ParentCategory;
use App\Models\ProductModel;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\View\View;

/**
 * Inventory dashboard: counter boxes, plus the QM approval queue for approvers.
 */
class DashboardController extends Controller
{
    public function __invoke(): View
    {
        // Purchase/transaction counts are per wing (Super Admin: all wings), like the lists they link to.
        $user = request()->user();
        $mine = fn ($query, $col = 'unit_id') => $user->isSuperAdmin() ? $query : $query->where($col, $user->unit_id);
        $orders = $mine(PurchaseOrder::query()->with('items'))->get();

        // [label, path, colour class, icon, tile colour, count] in the same order as the reference dashboard.
        $boxes = [
            ['Wings', 'inventory/configuration/units', 'text-primary', 'fa-solid fa-sitemap', '#2563eb', Unit::where('status', true)->count()],
            ['Suppliers', 'inventory/configuration/suppliers', 'text-info', 'fa-solid fa-truck-fast', '#0891b2', Supplier::active()->count()],
            ['Accounting Units', 'inventory/configuration/itemunits', 'text-secondary', 'fa-solid fa-scale-balanced', '#64748b', ItemUnit::active()->count()],
            ['Parent Categories', 'inventory/configuration/parentcategories', 'text-dark', 'fa-solid fa-layer-group', '#7c3aed', ParentCategory::active()->count()],
            ['Categories', 'inventory/configuration/categories', 'text-darkblue', 'fa-solid fa-tags', '#4f46e5', Category::active()->count()],
            ['Brands', 'inventory/configuration/brands', 'text-success', 'fa-solid fa-award', '#059669', Brand::active()->count()],
            ['Models', 'inventory/configuration/models', 'text-primary', 'fa-solid fa-cubes', '#0284c7', ProductModel::active()->count()],
            ['Items', 'inventory/configuration/items', 'text-primary', 'fa-solid fa-boxes-stacked', '#0d9488', Item::active()->count()],
            ['Purchase Order', 'inventory/purchase/purchaseorders', 'text-dark', 'fa-solid fa-file-invoice-dollar', '#334155', $orders->count()],
            ['Purchase Received', 'inventory/purchase/purchaseorderreceive', 'text-darkblue', 'fa-solid fa-truck-ramp-box', '#1e40af', $orders->filter(fn ($o) => $o->dueQty() === 0)->count()], // fully received POs, as in the reference
            ['Receive Due', null, 'text-secondary', 'fa-solid fa-hourglass-half', '#d97706', $orders->filter(fn ($o) => $o->dueQty() > 0)->count()],
            ['Stock Items', 'inventory/transaction/stockposition', 'text-success', 'fa-solid fa-warehouse', '#16a34a', $mine(Stock::inStock())->count()],
            ['Issue Voucher', 'inventory/transaction/issuevouchers', 'text-green', 'fa-solid fa-file-export', '#15803d', $mine(IssueVoucher::query(), 'from_unit_id')->count()],
            ['Damages', 'inventory/transaction/damages', 'text-warning', 'fa-solid fa-triangle-exclamation', '#dc2626', $mine(Damage::query())->count()],
            ['Warranty Items', 'inventory/transaction/warrantyandservice', 'text-info', 'fa-solid fa-shield-halved', '#0891b2', $mine(Stock::query())->where('coverage_type', 'Warranty')->count()],
            ['Warranty Claimed', 'inventory/transaction/warrantyandservice', 'text-primary', 'fa-solid fa-file-shield', '#6366f1', $mine(WarrantyClaim::query())->where('status', 'Claimed')->count()],
            ['Warranty Received', 'inventory/transaction/warrantyandservice', 'text-secondary', 'fa-solid fa-circle-check', '#64748b', $mine(WarrantyClaim::query())->whereIn('status', ['Received', 'Not Covered'])->count()],
            ['License', 'inventory/transaction/licenses', 'text-dark', 'fa-solid fa-key', '#475569', License::whereHas('stock', fn ($q) => $mine($q))->count()],
        ];

        // QM (and anyone who can see Approvals) gets the approval queue on top.
        $queue = $user->canMenu('inventory/approvals') ? ApprovalController::queue(request()) : null;

        return view('inventory.dashboard', compact('boxes', 'queue'));
    }
}
