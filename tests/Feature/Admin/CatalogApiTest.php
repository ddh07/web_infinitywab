<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogApiTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    public function test_service_store_and_update_via_form_request(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->postJson('/api/admin/services', [
            'title' => 'Maintenance réseau',
            'slug' => 'maintenance-reseau',
            'description' => 'Description du service',
            'is_active' => true,
            'order' => 1,
        ]);

        $response->assertStatus(201)->assertJsonPath('slug', 'maintenance-reseau');
        $id = $response->json('id');

        // Le slug reste valide sur sa propre ressource lors d'une mise à jour (unique->ignore).
        $update = $this->actingAs($admin)->putJson("/api/admin/services/{$id}", [
            'title' => 'Maintenance réseau avancée',
            'slug' => 'maintenance-reseau',
            'description' => 'Description mise à jour',
            'is_active' => true,
            'order' => 2,
        ]);

        $update->assertStatus(200)->assertJsonPath('title', 'Maintenance réseau avancée');
    }

    public function test_service_store_rejects_duplicate_slug(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->postJson('/api/admin/services', [
            'title' => 'A', 'slug' => 'dupe', 'description' => 'x',
        ])->assertStatus(201);

        $this->actingAs($admin)->postJson('/api/admin/services', [
            'title' => 'B', 'slug' => 'dupe', 'description' => 'y',
        ])->assertStatus(422)->assertJsonValidationErrors('slug');
    }

    public function test_project_store_applies_legacy_defaults(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->postJson('/api/admin/projects', [
            'title' => 'Portail client',
            'slug' => 'portail-client',
            'description' => 'Description',
            'client' => 'Client X',
            'is_active' => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('category', 'general')
            ->assertJsonPath('status', 'en_cours');
    }

    public function test_product_store_validates_required_fields(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->postJson('/api/admin/products', [
            'title' => 'Pack Wifi',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['slug', 'description', 'price', 'category']);
    }

    public function test_partner_store_maps_order_to_sort_order(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->postJson('/api/admin/partners', [
            'name' => 'AWS',
            'description' => 'Partenaire cloud',
            'category' => 'technology',
            'order' => 3,
        ]);

        $response->assertStatus(201)->assertJsonPath('sort_order', 3);
    }

    public function test_admin_api_requires_authentication(): void
    {
        $this->getJson('/api/admin/services')->assertStatus(302);
    }
}
