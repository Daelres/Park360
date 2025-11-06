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

        $items = DB::table('orden_item')->get();
        $boletos = [];
        foreach ($items as $item) {
            for ($i = 0; $i < $item->cantidad; $i++) {
                $boletos[] = [
                    'orden_id' => $item->orden_id,
                    'tipo_ticket_id' => $item->tipo_ticket_id,
                    'qr_code' => (string) Str::uuid(),
                    'estado' => 'emitido',
                    'valido_desde' => now()->toDateString(),
                    'valido_hasta' => now()->addDays(7)->toDateString(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        if (!empty($boletos)) {
            DB::table('boleto')->insert($boletos);
        }
    }
}
