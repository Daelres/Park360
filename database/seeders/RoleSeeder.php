<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrador', 'slug' => 'admin', 'description' => 'Acceso completo a la plataforma'],
            ['name' => 'Operador', 'slug' => 'operator', 'description' => 'Gestiona operaciones diarias'],
            ['name' => 'Cliente', 'slug' => 'customer', 'description' => 'Cliente con acceso a compras y check-in'],
        ];

        foreach ($roles as $role) {
            Role::query()->updateOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
