<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\ApprovalRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\IssueVoucher;
use App\Models\Item;
use App\Models\ParentCategory;
use App\Models\ProductModel;
use App\Models\PurchaseOrder;
use App\Models\PurchaseReceive;
use App\Notifications\ApprovalNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * QM Notification Center: approve or reject what the Storeman submitted.
 * Approved records reach the inventory; rejected ones never do.
 */
class ApprovalController extends Controller
{
    use JsonResponses;

    public const TABS = ['unread', 'material', 'purchase', 'stock', 'issue', 'read'];

    /** Relations each request type needs on its details page: [partial, relations]. */
    private const DETAILS = [
        Item::class => ['item', ['parentCategory', 'category', 'brand', 'productModel', 'port', 'layer', 'capacity', 'unit']],
        ParentCategory::class => ['parent-category', ['categories']],
        Category::class => ['category', ['parent', 'brands', 'models.brand', 'models.ports', 'models.layers', 'models.capacities']],
        Brand::class => ['brand', ['category', 'models.ports', 'models.layers', 'models.capacities']],
        ProductModel::class => ['model', ['brand', 'category', 'ports', 'layers', 'capacities']],
        PurchaseOrder::class => ['purchase-order', ['unit', 'supplier', 'financialYear', 'creator', 'items.item.category', 'items.item.brand', 'items.item.productModel', 'items.item.unit']],
        PurchaseReceive::class => ['purchase-receive', ['unit', 'supplier', 'financialYear', 'creator', 'purchaseOrder', 'items.item.category', 'items.item.brand', 'items.item.productModel', 'stocks.item.category', 'stocks.item.brand', 'stocks.item.productModel']],
        IssueVoucher::class => ['issue-voucher', ['fromUnit', 'creator', 'items.toUnit', 'items.actioner', 'items.stock.item.category', 'items.stock.item.brand', 'items.stock.item.productModel', 'items.stock.item.unit']],
    ];

    public function index(Request $request): View
    {
        $view = $request->boolean('partial') ? 'inventory.approvals._queue' : 'inventory.approvals.index';

        return view($view, self::queue($request));
    }

    /** Data for the queue (also shown on the inventory dashboard). */
    public static function queue(Request $request): array
    {
        $user = $request->user();
        $notifications = $user->notifications()->where('type', ApprovalNotification::class);
        $pending = ApprovalRequest::with('requester')->visibleTo($user)->where('status', 'Pending')->latest('id')->get();
        $requests = ApprovalRequest::whereIn('id', (clone $notifications)->latest()->limit(100)->get()->pluck('data.approval_id'))->get()->keyBy('id');

        return [
            'tab' => in_array($request->tab, self::TABS, true) ? $request->tab : 'unread',
            'unread' => (clone $notifications)->whereNull('read_at')->latest()->limit(50)->get(),
            'read' => (clone $notifications)->whereNotNull('read_at')->latest()->limit(50)->get(),
            'unreadCount' => (clone $notifications)->whereNull('read_at')->count(),
            'readCount' => (clone $notifications)->whereNotNull('read_at')->count(),
            'pending' => $pending->groupBy('category'),
            'categories' => ApprovalRequest::CATEGORIES,
            'requests' => $requests,
            'canDecide' => $user->canMenu('inventory/approvals', 'edit'),
        ];
    }

    /** Full details of one request (the queue's "Open" button); opening it marks its notification read. */
    public function show(Request $request, ApprovalRequest $approval): View
    {
        abort_unless($approval->visibleTo($request->user()), 404);
        $approval->load(['requester', 'actioner']);

        $record = $approval->approvable;
        [$partial, $relations] = $record ? self::DETAILS[$record::class] ?? [null, []] : [null, []];
        $record?->loadMissing($relations);

        $request->user()->unreadNotifications()->where('type', ApprovalNotification::class)
            ->where('data->approval_id', $approval->id)->update(['read_at' => now()]);

        return view('inventory.approvals.show', [
            'approval' => $approval,
            'record' => $record,
            'partial' => $partial,
            'recordUrl' => $record?->approvalCard()[6],
            'canDecide' => $approval->isPending() && $record && $request->user()->canMenu('inventory/approvals', 'edit'),
        ]);
    }

    public function approve(Request $request, ApprovalRequest $approval): JsonResponse
    {
        if ($error = $this->guard($request, $approval)) {
            return $error;
        }
        $approval->approve($request->user());

        return $this->ok("{$approval->reference} approved and added to the inventory.");
    }

    public function reject(Request $request, ApprovalRequest $approval): JsonResponse
    {
        if ($error = $this->guard($request, $approval)) {
            return $error;
        }
        $data = $this->check($request, ['reason' => ['required', 'string', 'max:1000']], ['reason' => 'Reason']);
        $approval->reject($request->user(), $data['reason']);

        return $this->ok("{$approval->reference} rejected.");
    }

    /** Mark one approval notification read (or all of them without an id). */
    public function read(Request $request, ?string $notification = null): JsonResponse
    {
        $request->user()->unreadNotifications()->where('type', ApprovalNotification::class)
            ->when($notification, fn ($q) => $q->whereKey($notification))
            ->update(['read_at' => now()]);

        return $this->ok($notification ? 'Notification marked as read.' : 'All notifications marked as read.');
    }

    private function guard(Request $request, ApprovalRequest $approval): ?JsonResponse
    {
        abort_unless($approval->visibleTo($request->user()), 404);
        if (! $approval->isPending()) {
            return $this->fail("{$approval->reference} has already been ".strtolower($approval->status).'.');
        }
        if (! $approval->approvable) {
            return $this->fail('This record no longer exists.');
        }

        return null;
    }
}
