<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * Runs against the seeded reference data (roles, permissions, configuration,
 * purchase orders and stock exported from the reference system).
 */
abstract class FeatureTestCase extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected function user(string $login): User
    {
        return User::where('name', $login)->firstOrFail();
    }

    /** A user of the given role in another wing (9 division). */
    protected function wingUser(string $roleSlug = 'storeman'): User
    {
        return User::create([
            'name' => 'wing9', 'email' => 'wing9@test.com', 'full_name' => 'Wing Nine', 'mobile_no' => '01700000009',
            'role_id' => Role::where('slug', $roleSlug)->value('id'), 'unit_id' => 5, 'rank_id' => 1,
            'join_date' => now(), 'password' => 'Test@12345', 'status' => true,
        ]);
    }

    /** AJAX request the way the front-end sends it. */
    protected function ajax(User $user, string $method, string $uri, array $data = []): TestResponse
    {
        return $this->actingAs($user)->json($method, $uri, $data, ['X-Requested-With' => 'XMLHttpRequest']);
    }
}
