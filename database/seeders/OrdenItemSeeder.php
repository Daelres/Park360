<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdenItemSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $ordenes = DB::table('orden')->pluck('id', 'numero_orden');
        $tipos = DB::table('tipo_ticket')->pluck('id', 'nombre');

        DB::table('orden_item')->insert([
            [
                'orden_id' => $ordenes['ORD-10001'] ?? 1,
                'tipo_ticket_id' => $tipos['General Día'] ?? 1,
                'cantidad' => 2,
                'precio_unitario' => 50000,
                'impuestos' => 9500,
                'descuento' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'orden_id' => $ordenes['ORD-10001'] ?? 1,
                'tipo_ticket_id' => $tipos['Nocturno'] ?? 1,
                'cantidad' => 1,
                'precio_unitario' => 50000,
                'impuestos' => 9500,
                'descuento' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'orden_id' => $ordenes['ORD-10002'] ?? 1,
                'tipo_ticket_id' => $tipos['Familiar Fin de Semana'] ?? 1,
                'cantidad' => 3,
                'precio_unitario' => 30000,
                'impuestos' => 5700,
                'descuento' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
