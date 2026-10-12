<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kenayafinances.com'],
            [
                'name' => 'Administrateur Kenaya',
                'password' => Hash::make('KenayaAdmin2025!'),
                'role' => 'admin',
            ]
        );

        $this->command->info('✅ Admin créé : admin@kenayafinances.com / KenayaAdmin2025!');
        $this->command->warn('⚠️  Changez ce mot de passe immédiatement après la première connexion.');
    }
}
