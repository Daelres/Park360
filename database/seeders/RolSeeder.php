<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        DB::table('rol')->insert([
            ['nombre' => 'admin', 'descripcion' => 'Administrador del sistema', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'operador', 'descripcion' => 'Operador de atracciones', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'ventas', 'descripcion' => 'Operador de ventas', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
