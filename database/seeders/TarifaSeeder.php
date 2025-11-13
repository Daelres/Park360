<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TarifaSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener tipos de ticket existentes
        $tipos = DB::table('tipo_ticket')->pluck('id')->toArray();

        if (empty($tipos)) {
            dd("⚠ No existen tipos de ticket para crear tarifas.");
        }

        $canales = [
            'web',
            'app',
            'taquilla',
            'kiosko',
        ];

        $tarifas = [];

        for ($i = 0; $i < 60; $i++) {

            // Fechas realistas de vigencia
            $desde = now()->subDays(rand(0, 90))->toDateString();
            $hasta = now()->addDays(rand(10, 90))->toDateString();

            // Regla simulada en JSON
            $regla = [
                'edad_min' => rand(0, 16) === 0 ? null : rand(0, 12),
                'edad_max' => rand(0, 16) === 0 ? null : rand(12, 70),
                'dias_semana' => array_rand([1, 2, 3, 4, 5, 6, 7], rand(1, 7)),
                'requiere_doc' => rand(0, 1) ? true : false,
                'bloqueado' => rand(0, 1) ? false : true,
            ];

            $tarifas[] = [
                'tipo_ticket_id' => $tipos[array_rand($tipos)],
                'precio' => rand(15000, 120000),
                'moneda' => 'COP',
                'vigncia_desde' => $desde,
                'vigncia_hasta' => $hasta,
                'canal_venta' => $canales[array_rand($canales)],
                'regla' => json_encode($regla),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tarifa')->insert($tarifas);
    }
}
