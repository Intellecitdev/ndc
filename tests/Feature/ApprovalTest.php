<?php

namespace Tests\Feature;

use App\Models\ApprovalRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Stock;
use App\Notifications\ApprovalNotification;

/**
 * Storeman creates -> pending + QM notified -> QM approves (reaches the inventory)
 * or rejects with a reason (never reaches it).
 */
class ApprovalTest extends FeatureTestCase
{
    public function test_material_waits_for_qm_and_appears_once_approved(): void
    {
        [$storeman, $qm] = [$this->user('Issuer'), $this->user('Purchaser')];

        $this->ajax($storeman, 'POST', '/inventory/configuration/categories', ['ParentCatID' => 1, 'Category' => 'Drones', 'C4S' => 'Y'])
            ->assertJson(['success' => true, 'message' => 'Category submitted for QM approval.']);
        $category = Category::where('name', 'Drones')->firstOrFail();
        $this->assertTrue($category->isPending());
        $this->assertFalse(Category::active()->whereKey($category->id)->exists(), 'pending masters stay out of dropdowns');

        // QM is told in real time; the Storeman can not decide it.
        $this->assertSame(1, $qm->unreadNotifications()->where('type', ApprovalNotification::class)->count());
        $this->ajax($qm, 'GET', '/user/live?since='.now()->subMinute()->getTimestamp())->assertJsonPath('events.0.approval', true);
        $approval = ApprovalRequest::where('approvable_id', $category->id)->where('category', 'material')->firstOrFail();
        $this->ajax($storeman, 'POST', "/inventory/approvals/{$approval->id}/approve")->assertForbidden();

        $this->ajax($qm, 'POST', "/inventory/approvals/{$approval->id}/approve")->assertJson(['success' => true]);
        $this->assertTrue(Category::active()->whereKey($category->id)->exists());
        $this->assertSame(0, $qm->unreadNotifications()->count(), 'decided requests leave the unread list');
        $this->assertSame('Category Approved', $storeman->notifications()->first()->data['subject']);

        // Deciding twice is refused.
        $this->ajax($qm, 'POST', "/inventory/approvals/{$approval->id}/reject", ['reason' => 'x'])->assertJson(['success' => false]);
    }

    public function test_rejection_needs_a_reason_and_keeps_the_item_out(): void
    {
        [$storeman, $qm] = [$this->user('Issuer'), $this->user('Purchaser')];
        $this->ajax($storeman, 'POST', '/inventory/configuration/items', [
            'ParentCatID' => 1, 'CategoryID' => Category::where('parent_category_id', 1)->value('id'), 'UnitID' => 1, 'Code' => 'T-DRN-1', 'Name' => 'Test Drone',
            'Warranty' => 0, 'Consumable' => 0, 'License' => 0, 'C4S' => 'Y',
        ])->assertJson(['success' => true]);
        $item = Item::where('code', 'T-DRN-1')->firstOrFail();
        $approval = $item->approvalRequests()->firstOrFail();

        $this->ajax($qm, 'POST', "/inventory/approvals/{$approval->id}/reject", [])->assertJson(['success' => false]);
        $this->ajax($qm, 'POST', "/inventory/approvals/{$approval->id}/reject", ['reason' => 'Duplicate of an existing item'])->assertJson(['success' => true]);

        $this->assertSame('Rejected', $item->fresh()->approval_status);
        $this->assertFalse(Item::active()->whereKey($item->id)->exists());
        $this->assertStringContainsString('Duplicate of an existing item', $storeman->notifications()->first()->data['message']);
        $this->actingAs($storeman)->get('/inventory/configuration/items')->assertSee('Rejected');
    }

    public function test_purchase_order_and_stock_entry_need_approval(): void
    {
        [$storeman, $qm] = [$this->user('Issuer'), $this->user('Purchaser')];

        $this->ajax($storeman, 'POST', '/inventory/purchase/purchaseorders', [
            'Date' => now()->toDateString(), 'SupplierID' => 1, 'FinYearID' => 1, 'ReferenceNo' => 'S-1', 'Priority' => 3,
            'items' => [['pid' => 14, 'qty' => 2]],
        ])->assertJson(['success' => true, 'message' => 'Purchase Order submitted for QM approval.']);
        $order = PurchaseOrder::latest('id')->firstOrFail();
        $this->assertTrue($order->isPending());
        $this->actingAs($storeman)->get('/inventory/purchase/purchaseorderreceive/create')->assertDontSee($order->po_no);

        $this->ajax($qm, 'POST', '/inventory/approvals/'.$order->approvalRequests()->value('id').'/approve')->assertJson(['success' => true]);
        $this->actingAs($storeman)->get('/inventory/purchase/purchaseorderreceive/create')->assertSee($order->po_no);

        // Stock entry: pending stock is not in stock; rejected -> gone and the PO is due again.
        $line = PurchaseOrderItem::where('purchase_order_id', $order->id)->firstOrFail();
        $receive = fn (array $serials) => $this->ajax($storeman, 'POST', '/inventory/purchase/purchaseorderreceive', [
            'Date' => now()->toDateString(), 'InvoiceNo' => 'INV-'.$serials[0], 'POID' => $order->id, 'ReceivedQty' => count($serials),
            'items' => [['id' => $line->id, 'qty' => count($serials), 'serial' => $serials]],
        ])->assertJson(['success' => true, 'message' => 'Stock entry submitted for QM approval.']);

        $receive(['S-SN-1', 'S-SN-2']);
        $this->assertSame([Stock::PENDING, Stock::PENDING], Stock::whereIn('serial_no', ['S-SN-1', 'S-SN-2'])->pluck('status')->all());
        $this->assertSame(2, $line->fresh()->received_qty);
        $entry = ApprovalRequest::where('category', 'stock')->latest('id')->firstOrFail();
        $this->ajax($qm, 'POST', "/inventory/approvals/{$entry->id}/reject", ['reason' => 'Wrong invoice'])->assertJson(['success' => true]);
        $this->assertSame(0, Stock::whereIn('serial_no', ['S-SN-1', 'S-SN-2'])->count());
        $this->assertSame(0, $line->fresh()->received_qty);

        $receive(['S-SN-3']);
        $entry = ApprovalRequest::where('category', 'stock')->latest('id')->firstOrFail();
        $this->ajax($qm, 'POST', "/inventory/approvals/{$entry->id}/approve")->assertJson(['success' => true]);
        $this->assertSame(Stock::IN_STOCK, Stock::where('serial_no', 'S-SN-3')->value('status'));
    }

    public function test_rejected_issue_puts_the_stock_back(): void
    {
        [$storeman, $qm] = [$this->user('Issuer'), $this->user('Purchaser')];
        $stock = Stock::inStock()->where('unit_id', $storeman->unit_id)->firstOrFail();

        $this->ajax($storeman, 'POST', '/inventory/transaction/stockposition', ['items' => [['rid' => $stock->id, 'unitid' => 5]]])->assertJson(['success' => true]);
        $this->assertSame(Stock::TRANSFERRED, $stock->fresh()->status);
        $this->actingAs($qm)->get('/inventory/approvals')->assertSee('New Issuance Request');

        $issue = ApprovalRequest::where('category', 'issue')->latest('id')->firstOrFail();
        $this->ajax($qm, 'POST', "/inventory/approvals/{$issue->id}/reject", ['reason' => 'Not needed'])->assertJson(['success' => true]);
        $this->assertSame(Stock::IN_STOCK, $stock->fresh()->status);
    }

    public function test_qm_and_admin_records_skip_the_queue(): void
    {
        $this->ajax($this->user('administrator'), 'POST', '/inventory/configuration/categories', ['ParentCatID' => 1, 'Category' => 'Admin Cat', 'C4S' => 'Y'])
            ->assertJson(['message' => 'Category created successfully.']);
        $this->assertTrue(Category::active()->where('name', 'Admin Cat')->exists());
        $this->assertSame(0, ApprovalRequest::count());
    }
}
