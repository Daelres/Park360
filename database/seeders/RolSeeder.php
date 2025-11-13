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
        DB::table('rol')->upsert([
            ['nombre' => 'admin', 'descripcion' => 'Administrador del sistema', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'employee', 'descripcion' => 'Empleado interno del parque', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'client', 'descripcion' => 'Cliente del parque', 'created_at' => $now, 'updated_at' => $now],
        ], ['nombre'], ['descripcion', 'updated_at']);
    }
}
