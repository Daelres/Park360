<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LecturaColaSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener todas las atracciones existentes
        $atracciones = DB::table('atraccion')->pluck('id')->toArray();

        if (empty($atracciones)) {
            dd("⚠ No hay atracciones para generar lecturas de cola.");
        }

        $fuentes = [
            'sensor',
            'manual',
            'sistema_central',
            'operador',
            'estimado'
        ];

        $lecturas = [];

        for ($i = 0; $i < 200; $i++) {

            // Fecha de lectura en los últimos 15 días
            $fechaLectura = now()
                ->subDays(rand(0, 15))
                ->subHours(rand(0, 23))
                ->subMinutes(rand(0, 59));

            // Simulación más realista: más personas = más tiempo de espera
            $personas = rand(0, 200);
            $tiempoEspera = $personas === 0 ? 0 : intval($personas / rand(3, 6));

            $lecturas[] = [
                'atraccion_id'       => $atracciones[array_rand($atracciones)],
                'personas_en_cola'   => $personas,
                'tiempo_espera_min'  => $tiempoEspera,
                'fuente'             => $fuentes[array_rand($fuentes)],
                'created_at'         => $fechaLectura,
                'updated_at'         => $fechaLectura,
            ];
        }

        DB::table('lectura_cola')->insert($lecturas);
    }
}
