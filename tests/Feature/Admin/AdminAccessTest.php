<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_when_accessing_admin_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_user_is_redirected_home_when_accessing_admin_dashboard(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/admin');

        $response->assertRedirect(route('home'));
    }

    public function test_unverified_admin_cannot_access_admin_dashboard(): void
    {
        $admin = User::factory()->unverified()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertRedirect(route('verification.notice'));
    }

    public function test_verified_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
    }

    public function test_non_admin_cannot_call_admin_user_api(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->getJson('/api/admin/users');

        $response->assertRedirect(route('home'));
    }
}
