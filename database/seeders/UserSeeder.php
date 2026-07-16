<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@infinity-wab.bf'],
            [
                'name' => 'Admin Infinity WAB',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'demo@infinity-wab.bf'],
            [
                'name' => 'Demo Infinity WAB',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );
    }
}

