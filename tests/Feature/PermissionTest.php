<?php

namespace Tests\Feature;

use App\Support\Menu;

class PermissionTest extends FeatureTestCase
{
    public function test_admin_can_open_every_menu_page(): void
    {
        $admin = $this->user('superadmin');
        foreach (Menu::pages()->pluck('path')->push('inventory', 'admin') as $path) {
            $this->actingAs($admin)->get('/'.$path)->assertOk();
        }
    }

    public function test_qm_sees_inventory_and_approvals_but_not_admin(): void
    {
        $qm = $this->user('Purchaser');
        $this->assertSame('qm', $qm->role->slug);
        $this->assertFalse($qm->needsApproval());
        $this->actingAs($qm)->get('/inventory/purchase/purchaseorders/create')->assertOk();
        $this->actingAs($qm)->get('/inventory/approvals')->assertOk()->assertSee('Approval Command Queue');
        $this->actingAs($qm)->get('/inventory')->assertOk()->assertSee('Approval Command Queue');
        $this->actingAs($qm)->get('/inventory/transaction/stockposition')->assertOk();
        $this->actingAs($qm)->get('/admin/users')->assertForbidden();
        $this->actingAs($qm)->get('/inventory/transaction/stockposition/create')->assertForbidden();
    }

    public function test_storeman_creates_but_cannot_approve_edit_or_delete(): void
    {
        $storeman = $this->user('Issuer');
        $this->assertSame('storeman', $storeman->role->slug);
        $this->assertTrue($storeman->needsApproval());
        $this->actingAs($storeman)->get('/inventory/transaction/stockposition/create')->assertOk();
        $this->actingAs($storeman)->get('/inventory/purchase/purchaseorders/create')->assertOk();
        $this->actingAs($storeman)->get('/inventory/configuration/items/create')->assertOk();
        $this->actingAs($storeman)->get('/inventory')->assertOk()->assertDontSee('Approval Command Queue');
        $this->actingAs($storeman)->get('/inventory/approvals')->assertForbidden();
        $this->actingAs($storeman)->get('/inventory/configuration/items/14/edit')->assertForbidden();
        $this->ajax($storeman, 'DELETE', '/inventory/purchase/purchaseorders/2')->assertForbidden();
    }

    public function test_admin_only_creates_users_in_own_wing(): void
    {
        $this->actingAs($this->user('administrator'))->get('/admin/users')
            ->assertOk()->assertSee('Total Online User')->assertDontSee('<option value="5">9 division</option>', false);
        $this->actingAs($this->user('superadmin'))->get('/admin/users')->assertSee('9 division');
    }

    public function test_data_is_scoped_to_the_users_wing(): void
    {
        // PO000001 belongs to ITDTE; the NDC administrator does not list it.
        $this->actingAs($this->user('administrator'))->get('/inventory/purchase/purchaseorders')
            ->assertSee('PO000002/2026-2027')->assertDontSee('PO000001/2026-2027');
        $this->actingAs($this->user('superadmin'))->get('/inventory/purchase/purchaseorders')->assertSee('PO000001/2026-2027');
    }
}
