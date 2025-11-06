<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CheckInSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $empleadoId = DB::table('empleado')->value('id');
        if (!$empleadoId) {
            return;
        }

        $boletos = DB::table('boleto')->limit(2)->get();
        $rows = [];
        foreach ($boletos as $boleto) {
            $rows[] = [
                'boleto_id' => $boleto->id,
                'acceso_por_id' => $empleadoId,
                'escaneado_at' => now()->subMinutes(5),
                'punto_acceso' => 'Entrada Norte',
                'resultado' => 'valido',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            DB::table('check_in')->insert($rows);
        }
    }
}
