<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificacionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $tipos = [
            'bienvenida',
            'orden_pagada',
            'incidente_reportado',
            'mantenimiento_programado',
            'recordatorio_visita',
            'boleto_validado',
            'cola_saturada',
            'atraccion_cerrada',
            'atraccion_reabierta',
            'alerta_sistema'
        ];

        $origenes = [
            'sistema',
            'ventas',
            'operaciones',
            'seguridad',
            'atracciones',
            'soporte'
        ];

        $notificaciones = [];

        for ($i = 1; $i <= 100; $i++) {

            $tipo = $tipos[array_rand($tipos)];
            $origen = $origenes[array_rand($origenes)];

            // Generar un payload dinámico según el tipo
            $payload = $this->generarPayload($tipo, $i);

            $notificaciones[] = [
                'tipo' => $tipo,
                'origen' => $origen,
                'payload' => json_encode($payload),
                'created_at' => $now->copy()->subMinutes(rand(0, 5000)),
                'updated_at' => $now,
            ];
        }

        DB::table('notificacion')->insert($notificaciones);
    }

    private function generarPayload(string $tipo, int $index): array
    {
        switch ($tipo) {

            case 'bienvenida':
                return [
                    'subject' => 'Bienvenido a Park360',
                    'message' => 'Gracias por registrarte en nuestra plataforma',
                    'ref' => Str::uuid(),
                ];

            case 'orden_pagada':
                return [
                    'orden_id' => $index,
                    'numero_orden' => 'ORD-' . str_pad($index, 5, '0', STR_PAD_LEFT),
                    'total' => rand(100000, 500000),
                ];

            case 'incidente_reportado':
                return [
                    'incidente_id' => rand(1, 80),
                    'mensaje' => 'Nuevo incidente registrado en la atracción.',
                ];

            case 'mantenimiento_programado':
                return [
                    'atraccion_id' => rand(1, 50),
                    'fecha' => now()->addDays(rand(1, 10))->toDateString(),
                    'mensaje' => 'Nuevo mantenimiento programado.',
                ];

            case 'recordatorio_visita':
                return [
                    'cliente_id' => rand(1, 100),
                    'fecha' => now()->addDay()->toDateString(),
                    'mensaje' => 'No olvides tu visita a Park360.',
                ];

            case 'boleto_validado':
                return [
                    'boleto_id' => rand(1, 100),
                    'resultado' => 'válido',
                    'punto' => 'Entrada Principal',
                ];

            case 'cola_saturada':
                return [
                    'atraccion_id' => rand(1, 20),
                    'personas' => rand(150, 300),
                    'mensaje' => 'Capacidad de cola superada.',
                ];

            case 'atraccion_cerrada':
                return [
                    'atraccion_id' => rand(1, 20),
                    'motivo' => 'Mantenimiento',
                ];

            case 'atraccion_reabierta':
                return [
                    'atraccion_id' => rand(1, 20),
                    'mensaje' => 'La atracción ha reanudado operaciones.',
                ];

            case 'alerta_sistema':
            default:
                return [
                    'codigo' => 'SYS-' . rand(1000, 9999),
                    'mensaje' => 'Se ha detectado una anomalía en el sistema.',
                ];
        }
    }
}
