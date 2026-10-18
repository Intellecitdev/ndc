<?php

namespace Tests\Feature;

use App\Models\ApprovalRequest;
use App\Models\IssueVoucherItem;
use App\Models\PurchaseOrderItem;
use App\Models\Stock;

/**
 * Purchase -> receive -> issue to another wing -> receive there -> deploy,
 * with each step done by the role that does it in the reference.
 */
class InventoryFlowTest extends FeatureTestCase
{
    public function test_full_inventory_flow(): void
    {
        $purchaser = $this->user('Purchaser');
        $issuer = $this->user('Issuer');
        $wing = $this->wingUser();

        $this->ajax($purchaser, 'POST', '/inventory/purchase/purchaseorders', [
            'Date' => now()->toDateString(), 'SupplierID' => 1, 'FinYearID' => 1, 'ReferenceNo' => 'T-1', 'Priority' => 3,
            'items' => [['pid' => 14, 'qty' => 2]],
        ])->assertOk()->assertJson(['success' => true]);
        $line = PurchaseOrderItem::latest('id')->first();
        // Numbered by row id (MySQL keeps auto-increments across the rolled-back tests).
        $this->assertSame(sprintf('PO%06d/2026-2027', $line->purchase_order_id), $line->purchaseOrder->po_no);

        // Received qty must match the lines.
        $this->ajax($purchaser, 'POST', '/inventory/purchase/purchaseorderreceive', [
            'Date' => now()->toDateString(), 'InvoiceNo' => 'INV-T1', 'POID' => $line->purchase_order_id, 'ReceivedQty' => 2,
            'items' => [['id' => $line->id, 'qty' => 2, 'serial' => ['T-SN-1', 'T-SN-2'],
                'type' => 'Warranty', 'startdate' => now()->toDateString(), 'duration' => 1, 'dtype' => 'Years']],
        ])->assertOk()->assertJson(['success' => true]);
        $stock = Stock::where('serial_no', 'T-SN-1')->firstOrFail();
        $this->assertSame(Stock::IN_STOCK, $stock->status);
        $this->assertFalse($stock->canDeploy(), 'store stock is issued, not deployed');

        // Duplicate serials are refused.
        $this->ajax($purchaser, 'POST', '/inventory/purchase/purchaseorderreceive', [
            'Date' => now()->toDateString(), 'InvoiceNo' => 'INV-T2', 'POID' => 2, 'ReceivedQty' => 1,
            'items' => [['id' => PurchaseOrderItem::where('purchase_order_id', 2)->where('item_id', 14)->value('id'), 'qty' => 1, 'serial' => ['T-SN-1']]],
        ])->assertOk()->assertJson(['success' => false]);

        // The Storeman's voucher waits for the QM; the wing hears of it only once approved.
        $this->ajax($issuer, 'POST', '/inventory/transaction/stockposition', ['items' => [['rid' => $stock->id, 'unitid' => 5]]])
            ->assertOk()->assertJson(['success' => true, 'message' => 'Issue Voucher submitted for QM approval.']);
        $this->assertSame(Stock::TRANSFERRED, $stock->fresh()->status);
        $this->assertSame(0, $wing->notifications()->count());
        $approval = ApprovalRequest::where('category', 'issue')->latest('id')->firstOrFail();
        $this->ajax($purchaser, 'POST', "/inventory/approvals/{$approval->id}/approve")->assertJson(['success' => true]);
        $this->assertSame(1, $wing->notifications()->count(), 'receiving wing is notified');
        $this->ajax($wing, 'GET', '/user/live')->assertOk()->assertJsonPath('counts.notifications', 1);

        $row = IssueVoucherItem::where('stock_id', $stock->id)->firstOrFail();
        $this->ajax($wing, 'PATCH', "/inventory/transaction/stockreceive/{$row->id}", ['formNo' => 1])->assertJson(['success' => true]);
        $stock->refresh();
        $this->assertSame(5, $stock->unit_id);
        $this->assertTrue($stock->canDeploy());

        $this->ajax($wing, 'PATCH', "/inventory/transaction/stockposition/{$stock->id}", [
            'Quantity' => 1, 'Unit' => 5, 'DeployDate' => now()->toDateString(), 'Personnel' => 'Maj Test',
        ])->assertJson(['success' => true]);
        $this->assertSame(Stock::DEPLOYED, $stock->fresh()->status);
    }

    public function test_store_stock_cannot_be_deployed(): void
    {
        $this->ajax($this->user('administrator'), 'PATCH', '/inventory/transaction/stockposition/1', [
            'Quantity' => 1, 'Unit' => 281, 'DeployDate' => now()->toDateString(), 'Personnel' => 'X',
        ])->assertJson(['success' => false]);
    }

    public function test_other_wing_cannot_touch_store_stock(): void
    {
        $this->ajax($this->wingUser(), 'POST', '/inventory/transaction/stockposition', ['items' => [['rid' => 1, 'unitid' => 3]]])
            ->assertJson(['success' => false]);
    }
}
