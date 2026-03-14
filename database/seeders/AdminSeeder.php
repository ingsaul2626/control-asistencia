<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder // <--- ¡AQUÍ ESTÁ EL CAMBIO! Debe llamarse AdminSeeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'approved',
        ]);
    }
}