<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        DB::table('permiso')->insert([
            ['nombre' => 'ver_dashboard', 'descripcion' => 'Acceso al panel principal', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'gestionar_usuarios', 'descripcion' => 'Crear/editar usuarios', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'gestionar_ventas', 'descripcion' => 'Crear y gestionar órdenes', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'operar_atracciones', 'descripcion' => 'Operación de atracciones y validación de boletos', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
