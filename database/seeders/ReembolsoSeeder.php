<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReembolsoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener pagos existentes (solo los que podrían haber tenido problemas)
        $pagos = DB::table('pago')->get();

        if ($pagos->isEmpty()) {
            dd("⚠ No existen pagos para generar reembolsos.");
        }

        $motivos = [
            'Cancelación de la orden',
            'Error de cobro',
            'Doble transacción',
            'Boleto no utilizado',
            'Solicitud del cliente',
            'Problemas técnicos en la atracción',
            'Incidente durante la visita',
            null,
        ];

        $estados = [
            'solicitado',
            'aprobado',
            'rechazado',
            'procesando'
        ];

        $registros = [];

        for ($i = 0; $i < 80; $i++) {

            $pago = $pagos->random();

            // Monto del reembolso nunca mayor al pago original
            $montoReembolso = rand(10000, intval($pago->monto));

            // Estado aleatorio
            $estado = $estados[array_rand($estados)];

            // Fecha de solicitud
            $requestedAt = now()
                ->subDays(rand(1, 20))
                ->subHours(rand(0, 12));

            // Solo aprobados y rechazados tienen confirmed_at
            $confirmedAt = in_array($estado, ['aprobado', 'rechazado'])
                ? (clone $requestedAt)->addHours(rand(1, 48))
                : null;

            $registros[] = [
                'pago_id' => $pago->id,
                'monto' => $montoReembolso,
                'motivo' => $motivos[array_rand($motivos)],
                'estado' => $estado,
                'requested_at' => $requestedAt,
                'confirmed_at' => $confirmedAt,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('reembolso')->insert($registros);
    }
}
