<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtraccionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $zonas = DB::table('zona')->pluck('id')->toArray();

        $nombres = [
            'Montaña Rusa Andina',
            'Río Lento Tropical',
            'Rueda Panorámica',
            'Casa del Terror Amazónico',
            'Splash Caribeño',
            'Tren de los Volcanes',
            'Torre del Vértigo',
            'Safari Jurásico',
            'Ciclón del Pacífico',
            'Vuelo del Cóndor'
        ];

        $estados = ['operativa', 'mantenimiento', 'cerrada'];

        $atracciones = [];

        for ($i = 0; $i < 10; $i++) {
            $atracciones[] = [
                'zona_id' => $zonas[array_rand($zonas)],
                'nombre' => $nombres[$i],
                'capacidad' => rand(15, 80),
                'estado_operativo' => $estados[array_rand($estados)],
                'ubicacion_gps' => $this->generarCoordenada(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('atraccion')->insert($atracciones);
    }

    private function generarCoordenada(): string
    {
        // Coordenadas aproximadas simuladas (rango aleatorio)
        $lat = 6.25 + (rand(-100, 100) / 10000);
        $lng = -75.56 + (rand(-100, 100) / 10000);

        return $lat . ',' . $lng;
    }
}
