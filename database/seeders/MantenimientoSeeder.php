<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MantenimientoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener IDs válidos
        $atractivos = DB::table('atraccion')->pluck('id')->toArray();
        $usuarios   = DB::table('users')->pluck('id')->toArray();

        if (empty($atractivos) || empty($usuarios)) {
            dd("⚠ No existen atracciones o usuarios para generar mantenimientos.");
        }

        $tipos = [
            'preventivo',
            'correctivo',
            'urgente',
            'ajuste técnico',
            'inspección general',
            'calibración de sensores',
            'lubricación de mecanismos',
        ];

        $estados = [
            'pendiente',
            'en progreso',
            'completado',
            'retrasado'
        ];

        $registros = [];

        for ($i = 0; $i < 60; $i++) {

            // Fechas programadas
            $inicioProgramado = now()
                ->subDays(rand(0, 40))
                ->toDateString();

            $finProgramado = now()
                ->subDays(rand(-5, 30))  // puede ser antes o después del inicio
                ->toDateString();

            // Fechas reales (pueden coincidir, adelantarse o retrasarse)
            $inicioReal = date('Y-m-d', strtotime($inicioProgramado . ' +' . rand(-2, 3) . ' days'));
            $finReal    = date('Y-m-d', strtotime($finProgramado . ' +' . rand(-2, 4) . ' days'));

            $registros[] = [
                'atractivo_id'      => $atractivos[array_rand($atractivos)],
                'tipo'              => $tipos[array_rand($tipos)],
                'inicio_programado' => $inicioProgramado,
                'fin_programado'    => $finProgramado,
                'inicio_real'       => $inicioReal,
                'fin_real'          => $finReal,
                'responsable'       => $usuarios[array_rand($usuarios)],
                'estado'            => $estados[array_rand($estados)],
                'created_at'        => $now,
                'updated_at'        => $now,
            ];
        }

        DB::table('mantenimiento')->insert($registros);
    }
}
