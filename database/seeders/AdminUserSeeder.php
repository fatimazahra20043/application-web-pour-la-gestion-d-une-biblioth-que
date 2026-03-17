<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Vérifie si l'admin existe déjà pour éviter les doublons
        $adminEmail = 'admin@gmail.com';

        if (!User::where('email', $adminEmail)->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => $adminEmail,
                'password' => Hash::make('12345678'), // Change le mot de passe
                'role' => 'admin',
            ]);
        }
    }
}
