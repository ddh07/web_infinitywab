<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceModeTest extends TestCase
{
    use RefreshDatabase;

    public function test_site_is_normally_accessible(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_visitor_sees_maintenance_page_when_enabled(): void
    {
        Setting::set('maintenance_enabled', '1');

        $response = $this->get('/');

        $response->assertStatus(503);
        $response->assertSee('Maintenance', false);
    }

    public function test_admin_can_still_reach_the_dashboard_during_maintenance(): void
    {
        Setting::set('maintenance_enabled', '1');
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
    }

    public function test_admin_can_still_reach_login_page_during_maintenance(): void
    {
        Setting::set('maintenance_enabled', '1');

        $this->get('/login')->assertOk();
    }

    public function test_admin_can_disable_maintenance_via_settings_api_while_it_is_active(): void
    {
        Setting::set('maintenance_enabled', '1');
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->putJson('/api/admin/settings', [
            'maintenance_enabled' => false,
        ]);

        $response->assertOk();
        $this->assertFalse((bool) Setting::get('maintenance_enabled'));
    }

    public function test_logged_in_admin_browsing_the_public_site_bypasses_maintenance(): void
    {
        Setting::set('maintenance_enabled', '1');
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get('/');

        $response->assertOk();
    }

    public function test_regular_visitor_is_blocked_from_public_pages_during_maintenance(): void
    {
        Setting::set('maintenance_enabled', '1');
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get('/services');

        $response->assertStatus(503);
    }
}
