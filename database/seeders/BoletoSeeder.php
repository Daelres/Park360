<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BoletoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener órdenes y tipos de ticket existentes
        $ordenes = DB::table('orden')->pluck('id')->toArray();
        $tipos = DB::table('tipo_ticket')->pluck('id')->toArray();

        // Asegurar que existan datos mínimos
        if (empty($ordenes) || empty($tipos)) {
            dd("⚠ No existen 'orden' o 'tipo_ticket' para generar boletos.");
        }

        $boletos = [];

        for ($i = 0; $i < 100; $i++) {

            $boletos[] = [
                'orden_id' => $ordenes[array_rand($ordenes)],
                'tipo_ticket_id' => $tipos[array_rand($tipos)],
                'qr_code' => (string)Str::uuid(),
                'estado' => ['emitido', 'usado', 'cancelado'][rand(0, 2)],
                'valido_desde' => now()->subDays(rand(0, 3))->toDateString(),
                'valido_hasta' => now()->addDays(rand(3, 10))->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('boleto')->insert($boletos);
    }
}
