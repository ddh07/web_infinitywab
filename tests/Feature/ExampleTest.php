<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the application homepage loads successfully.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200)
                 ->assertSee('Infinity WAB');
    }

    /**
     * Test that the services page loads correctly.
     */
    public function test_services_page_loads_successfully(): void
    {
        $response = $this->get('/services');

        $response->assertStatus(200)
                 ->assertSee('Services');
    }

    /**
     * Test that the contact page loads correctly.
     */
    public function test_contact_page_loads_successfully(): void
    {
        $response = $this->get('/contact');

        $response->assertStatus(200)
                 ->assertSee('Contact');
    }

    /**
     * Test that the about page loads correctly.
     */
    public function test_about_page_loads_successfully(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(200)
                 ->assertSee('About');
    }

    /**
     * Test that API endpoints return proper responses.
     */
    public function test_api_health_endpoint(): void
    {
        $response = $this->get('/api/health');

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'ok',
                     'timestamp' => true
                 ]);
    }

    /**
     * Test that 404 pages are handled correctly.
     */
    public function test_404_page_handling(): void
    {
        $response = $this->get('/non-existent-page');

        $response->assertStatus(404);
    }

    /**
     * Test that the application handles POST requests correctly.
     */
    public function test_contact_form_submission(): void
    {
        $contactData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Test message'
        ];

        $response = $this->post('/contact', $contactData);

        $response->assertRedirect()
                 ->assertSessionHas('success', 'Message sent successfully!');
    }
}
