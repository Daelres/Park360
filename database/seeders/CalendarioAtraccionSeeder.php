<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalendarioAtraccionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener atracciones existentes
        $atracciones = DB::table('atraccion')->pluck('id')->toArray();

        if (empty($atracciones)) {
            dd("⚠ No hay atracciones registradas para crear el calendario.");
        }

        $tipos = [
            'operativa',
            'mantenimiento',
            'cerrada temporalmente',
            'evento especial',
            'limpieza profunda'
        ];

        $registros = [];

        // Generar 50 entradas de calendario
        for ($i = 0; $i < 50; $i++) {

            $inicio = now()->subDays(rand(0, 60))->toDateString();

            // Un 30% de los registros tendrá fecha fin NULL
            $fin = rand(1, 100) <= 30
                ? null
                : now()->addDays(rand(1, 15))->toDateString();

            $registros[] = [
                'atraccion_id' => $atracciones[array_rand($atracciones)],
                'inicio' => $inicio,
                'fin' => $fin,
                'tipo' => $tipos[array_rand($tipos)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('calendario_atraccion')->insert($registros);
    }
}
