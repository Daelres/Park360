<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        DB::table('usuarios')->insert([
            ['email' => 'admin@park360.test', 'nombre' => 'Admin Principal', 'estado' => 'activo', 'ultimo_login' => null, 'created_at' => $now, 'updated_at' => $now],
            ['email' => 'operador@park360.test', 'nombre' => 'Operador Parque', 'estado' => 'activo', 'ultimo_login' => null, 'created_at' => $now, 'updated_at' => $now],
            ['email' => 'ventas@park360.test', 'nombre' => 'Operador Ventas', 'estado' => 'activo', 'ultimo_login' => null, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
