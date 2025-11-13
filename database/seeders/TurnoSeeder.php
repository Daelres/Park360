<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurnoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener empleados existentes
        $empleados = DB::table('empleado')->pluck('id')->toArray();

        if (empty($empleados)) {
            dd("⚠ No existen empleados para generar turnos.");
        }

        $rolesTurno = [
            'Operador Principal',
            'Operador Asistente',
            'Supervisor de Atracción',
            'Técnico de Guardia',
            'Seguridad de Área',
            'Taquillero',
            'Mantenimientos Programados',
            'Apoyo General'
        ];

        $turnos = [];

        for ($i = 0; $i < 150; $i++) {

            $inicio = now()
                ->subDays(rand(0, 30))
                ->setTime(rand(6, 14), rand(0, 59));

            // 80% de los turnos con fin registrado, 20% siguen abiertos
            $fin = rand(1, 100) <= 80
                ? (clone $inicio)->addHours(rand(6, 10))->addMinutes(rand(0, 59))
                : null;

            $turnos[] = [
                'empleado_id' => $empleados[array_rand($empleados)],
                'inicio_at' => $inicio,
                'fin_at' => $fin,
                'rol_turno' => $rolesTurno[array_rand($rolesTurno)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('turno')->insert($turnos);
    }
}
