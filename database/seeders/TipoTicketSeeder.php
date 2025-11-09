<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoTicketSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        DB::table('tipo_ticket')->insert([
            ['nombre' => 'General Día', 'validez_dias' => 1, 'reingresos' => true, 'descripcion' => 'Acceso general por 1 día', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Familiar Fin de Semana', 'validez_dias' => 2, 'reingresos' => true, 'descripcion' => 'Paquete familiar fin de semana', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Nocturno', 'validez_dias' => 1, 'reingresos' => false, 'descripcion' => 'Acceso nocturno', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
