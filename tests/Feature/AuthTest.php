<?php

namespace Tests\Feature;

class AuthTest extends FeatureTestCase
{
    public function test_guests_are_sent_to_login(): void
    {
        $this->get('/inventory')->assertRedirect('/login');
        $this->get('/login')->assertOk()->assertSee('LOGIN');
    }

    public function test_login_by_login_name_or_email(): void
    {
        $this->post('/login', ['email' => 'administrator', 'password' => 'Admin@2026'])->assertRedirect(route('inventory.dashboard'));
        $this->assertAuthenticated();

        $this->post('/logout');
        $this->post('/login', ['email' => 'purchaser@test.com', 'password' => 'Test@2026'])->assertRedirect();
        $this->assertAuthenticatedAs($this->user('Purchaser'));
    }

    public function test_wrong_password_is_rejected_and_audited(): void
    {
        $this->post('/login', ['email' => 'administrator', 'password' => 'nope'])->assertSessionHasErrors();
        $this->assertGuest();
        $this->assertDatabaseHas('ip_audits', ['reason' => 'Failed Login']);
    }

    public function test_inactive_user_cannot_login(): void
    {
        $this->user('Issuer')->update(['status' => false]);
        $this->post('/login', ['email' => 'Issuer', 'password' => 'Test@2026']);
        $this->assertGuest();
    }
}
