<?php

namespace Tests\Feature;

use App\Models\PurchaseOrder;
use App\Models\QuickLink;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use App\Support\Excel;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * Regression tests for the pre-deployment security audit.
 */
class SecurityTest extends FeatureTestCase
{
    /** A user in the administrator's wing whose role has only the given permissions. */
    private function limitedUser(array $permissions, string $slug = 'useradmin'): User
    {
        $role = Role::create(['name' => ucfirst($slug), 'slug' => $slug]);
        $role->syncPermissions($permissions);

        return User::create([
            'name' => $slug.'1', 'email' => $slug.'@test.com', 'full_name' => ucfirst($slug), 'mobile_no' => '01700000011',
            'role_id' => $role->id, 'unit_id' => $this->user('administrator')->unit_id, 'rank_id' => 1,
            'join_date' => now(), 'password' => 'Test@12345', 'status' => true,
        ]);
    }

    private function userPayload(array $overrides = []): array
    {
        return $overrides + [
            'name' => 'newbie', 'email' => 'newbie@test.com', 'MobileNo' => '01700000022', 'fullName' => 'New Bie',
            'unitID' => $this->user('administrator')->unit_id, 'rankID' => 1,
            'password' => 'Strong@2026', 'confirm_password' => 'Strong@2026',
        ];
    }

    public function test_bookmarks_only_accept_http_links_and_old_bad_links_are_neutralised(): void
    {
        $qm = $this->user('Purchaser');
        $this->ajax($qm, 'POST', '/user/quicklink', ['title' => 'x', 'link' => 'javascript:alert(1)'])->assertJson(['success' => false]);
        $this->ajax($qm, 'POST', '/user/quicklink', ['title' => 'x', 'link' => '//evil.example'])->assertJson(['success' => false]);
        $this->ajax($qm, 'POST', '/user/quicklink', ['title' => 'Stock', 'link' => 'http://localhost/inventory'])
            ->assertJson(['success' => true, 'redirect' => 'http://localhost/inventory']);

        // A link saved before validation existed is never rendered as a script URL (admins see everyone's).
        QuickLink::create(['user_id' => $qm->id, 'title' => 'old', 'link' => 'javascript:alert(document.cookie)', 'is_active' => true]);
        $this->actingAs($this->user('administrator'))->get('/user/quicklink')->assertOk()->assertDontSee('href="javascript:alert', false);
        $this->actingAs($qm)->get('/welcome')->assertOk()->assertDontSee('href="javascript:alert', false);
    }

    public function test_security_headers_are_sent(): void
    {
        $this->get('/login')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Content-Security-Policy', "frame-ancestors 'self'; object-src 'none'; base-uri 'self'");
    }

    public function test_logout_only_works_by_post(): void
    {
        $this->actingAs($this->user('administrator'))->get('/logout')->assertStatus(405);
        $this->assertAuthenticated();
    }

    public function test_user_managers_cannot_grant_more_rights_than_they_hold(): void
    {
        $manager = $this->limitedUser(['admin/users|view', 'admin/users|create', 'admin/users|edit']);
        $adminRole = Role::where('slug', 'admin')->value('id');

        $this->ajax($manager, 'POST', '/admin/users', $this->userPayload(['roleid' => $adminRole]))
            ->assertJson(['success' => false])->assertJsonValidationErrors('roleid');
        $this->ajax($manager, 'POST', '/admin/users', $this->userPayload(['roleid' => $manager->role_id, 'unitID' => 5]))
            ->assertJson(['success' => false])->assertJsonValidationErrors('unitID');
        $this->ajax($manager, 'POST', '/admin/users', $this->userPayload(['roleid' => $manager->role_id]))
            ->assertJson(['success' => true]);

        // Can't reset the password of (and so take over) an account with more rights.
        $this->ajax($manager, 'PATCH', '/admin/users/'.$this->user('administrator')->id.'/password', ['password' => 'Strong@2026', 'confirm_password' => 'Strong@2026'])
            ->assertForbidden();
    }

    public function test_role_editors_cannot_grant_themselves_new_permissions(): void
    {
        $editor = $this->limitedUser(['admin/roles|view', 'admin/roles|edit'], 'roleeditor');

        $this->ajax($editor, 'PUT', '/admin/roles/'.$editor->role_id, [
            'name' => 'Roleeditor', 'permissions' => ['admin/roles|view', 'admin/roles|edit', 'admin/users|create', 'admin/ipfiltering|delete'],
        ])->assertJson(['success' => true]);

        $this->assertEqualsCanonicalizing(['admin/roles|view', 'admin/roles|edit'], $editor->role->fresh()->permissions->map(fn ($p) => "$p->path|$p->ability")->all());
    }

    public function test_admin_still_manages_users_and_roles(): void
    {
        $admin = $this->user('administrator');
        $qmRole = Role::where('slug', 'qm')->value('id');

        $this->ajax($admin, 'POST', '/admin/users', $this->userPayload(['roleid' => $qmRole]))->assertJson(['success' => true]);
        $this->ajax($admin, 'PATCH', '/admin/users/'.$this->user('Issuer')->id.'/password', ['password' => 'Strong@2026', 'confirm_password' => 'Strong@2026'])
            ->assertJson(['success' => true]);
        $this->ajax($admin, 'PATCH', '/admin/users/'.$this->user('superadmin')->id.'/password', ['password' => 'Strong@2026', 'confirm_password' => 'Strong@2026'])
            ->assertForbidden();
    }

    public function test_new_passwords_must_be_strong_and_changing_needs_the_current_one(): void
    {
        $qm = $this->user('Purchaser');
        $url = '/user/profile/'.$qm->id;

        $this->ajax($qm, 'PATCH', $url, ['_form' => 1, 'password' => 'Strong@2027', 'confirm_password' => 'Strong@2027'])
            ->assertJsonValidationErrors('current_password');
        $this->ajax($qm, 'PATCH', $url, ['_form' => 1, 'current_password' => 'Test@2026', 'password' => '123456', 'confirm_password' => '123456'])
            ->assertJsonValidationErrors('password');
        $this->ajax($qm, 'PATCH', $url, ['_form' => 1, 'current_password' => 'Test@2026', 'password' => 'Strong@2027', 'confirm_password' => 'Strong@2027'])
            ->assertJson(['success' => true]);

        $this->post('/logout');
        $this->post('/login', ['email' => 'Purchaser', 'password' => 'Strong@2027']);
        $this->assertAuthenticatedAs($qm);
    }

    public function test_private_uploads_are_served_only_to_allowed_users(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('tickets/t.pdf', '%PDF-1.4 test');
        Storage::disk('public')->put('purchase-orders/p.png', 'png');

        $ticket = Ticket::create(['user_id' => $this->user('Purchaser')->id, 'subject' => 's', 'details' => 'd', 'attachment' => 'tickets/t.pdf']);
        $this->actingAs($this->user('Purchaser'))->get('/attachments/ticket/'.$ticket->id)->assertOk();
        $this->actingAs($this->user('administrator'))->get('/attachments/ticket/'.$ticket->id)->assertOk(); // Admin > Tickets
        $this->actingAs($this->user('Issuer'))->get('/attachments/ticket/'.$ticket->id)->assertForbidden();

        $admin = $this->user('administrator');
        $order = PurchaseOrder::where('unit_id', $admin->unit_id)->firstOrFail();
        $order->update(['attachment' => 'purchase-orders/p.png']);
        $this->actingAs($admin)->get('/attachments/purchaseorder/'.$order->id)->assertOk();
        $this->actingAs($this->user('Purchaser'))->get('/attachments/purchaseorder/'.$order->id)->assertOk(); // QM approval page
        $this->actingAs($this->wingUser())->get('/attachments/purchaseorder/'.$order->id)->assertNotFound(); // other wing
    }

    public function test_lookups_need_an_inventory_permission(): void
    {
        $outsider = $this->limitedUser(['admin/logs|view'], 'auditor');
        $this->ajax($outsider, 'GET', '/inventory/getitemlist')->assertForbidden();
        $this->ajax($outsider, 'GET', '/inventory/serialnochecking?SerialNo=X')->assertForbidden();
        $this->ajax($this->user('Issuer'), 'GET', '/inventory/getitemlist')->assertOk()->assertJson(['success' => true]);
    }

    public function test_many_failed_logins_from_one_ip_are_locked_out(): void
    {
        foreach (range(1, 20) as $i) {
            $this->post('/login', ['email' => "nobody$i", 'password' => 'wrong']);
        }
        $this->post('/login', ['email' => 'administrator', 'password' => 'Admin@2026'])->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->assertDatabaseHas('ip_audits', ['reason' => 'Too Many Login Attempts']);
    }

    public function test_excel_export_writes_text_not_formulas(): void
    {
        ob_start();
        Excel::download('Test', ['Name', 'Qty'], [['=HYPERLINK("http://evil","x")', 5]])->sendContent();
        $file = tempnam(sys_get_temp_dir(), 'xlsx');
        file_put_contents($file, ob_get_clean());

        $sheet = IOFactory::load($file)->getActiveSheet();
        unlink($file);
        $this->assertSame(DataType::TYPE_STRING, $sheet->getCell('A7')->getDataType());
        $this->assertSame(DataType::TYPE_NUMERIC, $sheet->getCell('B7')->getDataType());
    }
}
