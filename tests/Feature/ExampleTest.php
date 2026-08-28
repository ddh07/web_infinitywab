<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_services_page_loads_successfully(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200);
    }

    public function test_contact_page_loads_successfully(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200);
    }

    public function test_about_page_loads_successfully(): void
    {
        $response = $this->get('/a-propos');

        $response->assertStatus(200);
    }

    public function test_health_endpoint(): void
    {
        $response = $this->get('/up');

        $response->assertStatus(200);
    }

    public function test_404_page_handling(): void
    {
        $response = $this->get('/non-existent-page');

        $response->assertStatus(404);
    }

    public function test_contact_form_submission(): void
    {
        $contactData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Demande de renseignements',
            'message' => 'Test message',
        ];

        $response = $this->post('/contact', $contactData);

        $response->assertRedirect(route('contact.thanks'));

        $this->assertDatabaseHas('messages', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
}
