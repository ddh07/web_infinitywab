<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_admin_can_list_users(): void
    {
        $admin = $this->admin();
        User::factory()->count(2)->create();

        $response = $this->actingAs($admin)->getJson('/api/admin/users');

        $response->assertOk()->assertJsonCount(3);
    }

    public function test_admin_can_create_user_with_strong_password(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->postJson('/api/admin/users', [
            'name' => 'Nouvel utilisateur',
            'email' => 'nouveau@example.com',
            'password' => 'Str0ng!Passw0rd#26',
            'password_confirmation' => 'Str0ng!Passw0rd#26',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'nouveau@example.com', 'is_admin' => false]);
    }

    public function test_creating_user_rejects_weak_password(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->postJson('/api/admin/users', [
            'name' => 'Nouvel utilisateur',
            'email' => 'nouveau@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(422)->assertJsonValidationErrors('password');
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->deleteJson("/api/admin/users/{$admin->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_can_delete_another_user(): void
    {
        $admin = $this->admin();
        $other = User::factory()->create();

        $response = $this->actingAs($admin)->deleteJson("/api/admin/users/{$other->id}");

        $response->assertOk();
        $this->assertDatabaseMissing('users', ['id' => $other->id]);
    }

    public function test_non_admin_cannot_create_users(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->postJson('/api/admin/users', [
            'name' => 'Nouvel utilisateur',
            'email' => 'nouveau@example.com',
            'password' => 'Str0ng!Passw0rd#26',
            'password_confirmation' => 'Str0ng!Passw0rd#26',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseMissing('users', ['email' => 'nouveau@example.com']);
    }
}
