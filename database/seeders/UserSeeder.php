<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminPassword = env('ADMIN_SEED_PASSWORD') ?: Str::password(20);

        User::updateOrCreate(
            ['email' => 'nazaireodg07@gmail.com'],
            [
                'name' => 'Admin Infinity WAB',
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        if (! env('ADMIN_SEED_PASSWORD')) {
            $this->command?->warn("Admin account created with generated password: {$adminPassword}");
            $this->command?->warn('Store it securely and change it after first login.');
        }

        if (! app()->isProduction()) {
            $demoPassword = env('DEMO_SEED_PASSWORD') ?: Str::password(20);

            User::updateOrCreate(
                ['email' => 'demo@infinity-wab.bf'],
                [
                    'name' => 'Demo Infinity WAB',
                    'password' => Hash::make($demoPassword),
                    'is_admin' => false,
                ]
            );

            if (! env('DEMO_SEED_PASSWORD')) {
                $this->command?->warn("Demo account created with generated password: {$demoPassword}");
            }
        }
    }
}

