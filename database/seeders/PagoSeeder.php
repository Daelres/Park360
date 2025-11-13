<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PagoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener órdenes existentes
        $ordenes = DB::table('orden')->pluck('id')->toArray();

        if (empty($ordenes)) {
            dd("⚠ No existen órdenes para generar pagos.");
        }

        $proveedores = [
            'Wompi',
            'PayU',
            'Stripe',
            'Datafono',
            'Efectivo',
            'Nequi',
            'Daviplata'
        ];

        $estados = [
            'aprobado',
            'pendiente',
            'fallido',
            'reembolsado'
        ];

        $pagos = [];

        for ($i = 0; $i < 150; $i++) {

            $estado = $estados[array_rand($estados)];

            // Si está aprobado o reembolsado → tiene fecha y códigos
            $isProcessed = in_array($estado, ['aprobado', 'reembolsado']);

            $paidAt = $isProcessed
                ? now()->subMinutes(rand(10, 30000))
                : null;

            $autCode = $isProcessed
                ? strtoupper(Str::random(12))
                : null;

            $transExt = $isProcessed
                ? 'TRX-' . strtoupper(Str::random(10))
                : null;

            $pagos[] = [
                'orden_id' => $ordenes[array_rand($ordenes)],
                'proveedor' => $proveedores[array_rand($proveedores)],
                'monto' => rand(50000, 350000),
                'moneda' => 'COP',
                'estado' => $estado,
                'aut_code' => $autCode,
                'trans_id_ext' => $transExt,
                'paid_at' => $paidAt,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('pago')->insert($pagos);
    }
}
