<?php

namespace Tests\Feature;

use App\Models\IssueVoucher;
use App\Models\PurchaseOrder;
use App\Models\Stock;

class ReferenceDataTest extends FeatureTestCase
{
    public function test_reference_transactions_are_imported(): void
    {
        $this->assertSame(4, PurchaseOrder::count());
        $this->assertSame(4, PurchaseOrder::find(2)->dueQty());
        $this->assertSame(9, Stock::inStock()->count());
        $this->assertSame(Stock::TRANSFERRED, Stock::where('serial_no', '444')->value('status'));
        $this->assertSame('IV-00000001', IssueVoucher::find(11)->iv_no);
    }

    public function test_dashboard_counts_match_the_reference(): void
    {
        $page = $this->actingAs($this->user('administrator'))->get('/inventory')->assertOk();
        foreach (['Purchase Order' => 3, 'Purchase Received' => 2, 'Receive Due' => 1, 'Stock Items' => 9, 'Issue Voucher' => 1] as $box => $n) {
            $page->assertSeeInOrder([$box, (string) $n]);
        }
    }

    public function test_pdfs_render(): void
    {
        $admin = $this->user('administrator');
        foreach (['/inventory/purchase/purchaseorders/pdf/2', '/inventory/purchase/purchaseorderreceive/pdf/1',
                  '/inventory/transaction/stockposition/pdf/11', '/inventory/transaction/barcodes/pdf/1'] as $url) {
            $this->actingAs($admin)->get($url)->assertOk()->assertHeader('content-type', 'application/pdf');
        }
    }
}
