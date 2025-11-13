<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $roles = [
            ['nombre' => 'admin', 'descripcion' => 'Administrador del sistema'],
            ['nombre' => 'employee', 'descripcion' => 'Empleado interno del parque'],
            ['nombre' => 'client', 'descripcion' => 'Cliente del parque'],
        ];

        foreach ($roles as $role) {
            DB::table('rol')->updateOrInsert(
                ['nombre' => $role['nombre']],
                [
                    'descripcion' => $role['descripcion'],
                    'updated_at' => $now,
                    'created_at' => $now,
                ]
            );
        }
    }
}
