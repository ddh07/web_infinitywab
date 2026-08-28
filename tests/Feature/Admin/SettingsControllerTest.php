<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_guest_cannot_read_settings(): void
    {
        $response = $this->getJson('/api/admin/settings');

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_update_and_read_back_non_sensitive_settings(): void
    {
        $response = $this->actingAs($this->admin())->putJson('/api/admin/settings', [
            'gtm_container_id' => 'GTM-ABC1234',
            'ga4_property_id' => '123456789',
        ]);

        $response->assertOk();

        $this->actingAs($this->admin())
            ->getJson('/api/admin/settings')
            ->assertOk()
            ->assertJson([
                'gtm_container_id' => 'GTM-ABC1234',
                'ga4_property_id' => '123456789',
            ]);
    }

    public function test_sensitive_values_are_never_returned_in_plaintext(): void
    {
        $this->actingAs($this->admin())->putJson('/api/admin/settings', [
            'mail_password' => 'super-secret-pw',
        ]);

        $response = $this->actingAs($this->admin())->getJson('/api/admin/settings');

        $response->assertOk()
            ->assertJson(['mail_password_set' => true])
            ->assertJsonMissing(['mail_password' => 'super-secret-pw']);

        $this->assertStringNotContainsString('super-secret-pw', $response->getContent());
    }

    public function test_sensitive_value_is_encrypted_at_rest_in_the_database(): void
    {
        $this->actingAs($this->admin())->putJson('/api/admin/settings', [
            'mail_password' => 'super-secret-pw',
        ]);

        $raw = \DB::table('settings')->where('key', 'mail_password')->value('value');

        $this->assertStringNotContainsString('super-secret-pw', (string) $raw);
        $this->assertSame('super-secret-pw', Setting::get('mail_password'));
    }

    public function test_blank_sensitive_field_does_not_erase_existing_value(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->putJson('/api/admin/settings', [
            'mail_password' => 'super-secret-pw',
        ]);

        $this->actingAs($admin)->putJson('/api/admin/settings', [
            'mail_password' => '',
            'gtm_container_id' => 'GTM-ABC1234',
        ])->assertOk();

        $this->assertSame('super-secret-pw', Setting::get('mail_password'));
    }

    public function test_invalid_ga4_credentials_json_is_rejected(): void
    {
        $response = $this->actingAs($this->admin())->putJson('/api/admin/settings', [
            'ga4_credentials_json' => '{not valid json',
        ]);

        $response->assertStatus(422);
    }

    public function test_non_admin_cannot_update_settings(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->putJson('/api/admin/settings', [
            'gtm_container_id' => 'GTM-ABC1234',
        ]);

        $response->assertRedirect(route('home'));
    }
}
