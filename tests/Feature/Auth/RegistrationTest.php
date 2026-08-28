<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function strongPassword(): string
    {
        return 'Str0ng!Passw0rd#26';
    }

    public function test_user_can_register_with_a_strong_password(): void
    {
        $response = $this->post('/register', [
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'password' => $this->strongPassword(),
            'password_confirmation' => $this->strongPassword(),
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'jean.dupont@example.com',
            'is_admin' => false,
        ]);
        $response->assertRedirect(route('verification.notice'));
    }

    public function test_registration_is_rejected_when_password_is_too_weak(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('password');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'jean.dupont@example.com']);
    }

    public function test_registration_is_rejected_with_duplicate_email(): void
    {
        User::factory()->create(['email' => 'existe@example.com']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'Jean Dupont',
            'email' => 'existe@example.com',
            'password' => $this->strongPassword(),
            'password_confirmation' => $this->strongPassword(),
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_registration_cannot_grant_admin_via_mass_assignment(): void
    {
        $this->post('/register', [
            'name' => 'Attaquant',
            'email' => 'attaquant@example.com',
            'password' => $this->strongPassword(),
            'password_confirmation' => $this->strongPassword(),
            'is_admin' => true,
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'attaquant@example.com',
            'is_admin' => false,
        ]);
    }
}
