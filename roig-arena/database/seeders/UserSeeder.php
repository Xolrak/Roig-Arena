<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador
        User::create([
            'nombre' => 'Admin',
            'apellido' => 'Sistema',
            'email' => 'admin@roigarena.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);

        // Usuarios de prueba
        User::create([
            'nombre' => 'Martin',
            'apellido' => 'Rojo',
            'email' => 'mrojo@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::create([
            'nombre' => 'Pau',
            'apellido' => 'Lopez',
            'email' => 'plopez@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        User::create([
            'nombre' => 'Carlos',
            'apellido' => 'Castañeda',
            'email' => 'ccastaneda@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        $this->command->info('✅ Usuarios creados: 4 (1 admin + 3 normales)');
    }
}