<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckInSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener todos los empleados y boletos existentes
        $empleados = DB::table('empleado')->pluck('id')->toArray();
        $boletos = DB::table('boleto')->pluck('id')->toArray();

        if (empty($empleados) || empty($boletos)) {
            dd("⚠ No existen empleados o boletos para generar check-ins.");
        }

        $puntosAcceso = [
            'Entrada Norte',
            'Entrada Sur',
            'Entrada Principal',
            'Entrada VIP',
            'Entrada Occidente'
        ];

        $resultados = ['valido', 'rechazado', 'vencido'];

        $rows = [];

        for ($i = 0; $i < 100; $i++) {

            // Fecha de escaneo aleatoria (últimos 7 días)
            $escaneado = now()
                ->subDays(rand(0, 7))
                ->subHours(rand(0, 12))
                ->subMinutes(rand(0, 59));

            $rows[] = [
                'boleto_id' => $boletos[array_rand($boletos)],
                'acceso_por_id' => $empleados[array_rand($empleados)],
                'escaneado_at' => $escaneado,
                'punto_acceso' => $puntosAcceso[array_rand($puntosAcceso)],
                'resultado' => $resultados[array_rand($resultados)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('check_in')->insert($rows);
    }
}
