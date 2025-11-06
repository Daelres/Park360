<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtraccionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $zonas = DB::table('zona')->pluck('id', 'nombre');

        DB::table('atraccion')->insert([
            [
                'zona_id' => $zonas['Zona A'] ?? 1,
                'nombre' => 'Montaña Rusa Andina',
                'capacidad' => 24,
                'estado_operativo' => 'operativa',
                'ubicacion_gps' => '6.2518,-75.5636',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'zona_id' => $zonas['Zona B'] ?? 1,
                'nombre' => 'Río Lento Tropical',
                'capacidad' => 60,
                'estado_operativo' => 'mantenimiento',
                'ubicacion_gps' => '6.2520,-75.5650',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'zona_id' => $zonas['Zona C'] ?? 1,
                'nombre' => 'Rueda Panorámica',
                'capacidad' => 40,
                'estado_operativo' => 'operativa',
                'ubicacion_gps' => '6.2535,-75.5640',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
