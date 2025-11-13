<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsistenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generar registros de prueba
        for ($i = 1; $i <= 50; $i++) {
            $checkIn = Carbon::now()->subDays(rand(1, 30))->setTime(rand(6, 10), rand(0, 59));
            $checkOut = (clone $checkIn)->addHours(rand(6, 10))->addMinutes(rand(0, 59));

            DB::table('asistencia')->insert([
                'empleado_id' => rand(1, 20),
                'turno_id' => rand(1, 5),
                'check_in_at' => $checkIn,
                'check_out_at' => $checkOut,
                'metodo' => ['Tarjeta', 'Biométrico', 'Manual'][rand(0, 2)],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
