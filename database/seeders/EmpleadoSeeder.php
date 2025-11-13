<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpleadoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        // Mapear usuarios existentes por email para asociarlos
        $usuarios = DB::table('users')->pluck('id', 'email');

        $data = [];

        if (isset($usuarios['operador@park360.test'])) {
            $data[] = [
                'user_id' => $usuarios['operador@park360.test'],
                'documento' => 'EMP-1001',
                'cargo' => 'Operador',
                'area' => 'Atracciones',
                'fecha_ingreso' => now()->subYears(1)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (isset($usuarios['ventas@park360.test'])) {
            $data[] = [
                'user_id' => $usuarios['ventas@park360.test'],
                'documento' => 'EMP-1002',
                'cargo' => 'Cajero',
                'area' => 'Ventas',
                'fecha_ingreso' => now()->subMonths(6)->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($data)) {
            DB::table('empleado')->upsert($data, ['documento'], ['user_id', 'cargo', 'area', 'fecha_ingreso', 'updated_at']);
        }
    }
}
