<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Seed de pagos realistas con distribución temporal
     * - Pagos de hoy (para dashboard)
     * - Pagos de ayer (para comparación)
     * - Pagos históricos (últimos 30 días)
     */
    public function run(): void
    {
        $now = now();

        // Obtener órdenes existentes
        $ordenes = DB::table('orden')->pluck('id')->toArray();

        if (empty($ordenes)) {
            $this->command->error("⚠️ No existen órdenes. Ejecuta OrdenSeeder primero.");
            return;
        }

        // Proveedores de pago reales de Colombia
        $proveedores = [
            'Wompi',
            'PayU',
            'Stripe',
            'MercadoPago',
            'PSE',
            'Nequi',
            'Daviplata',
            'Bancolombia',
            'Efectivo',
            'Datafono'
        ];

        // Estados de pago
        $estados = [
            'aprobado' => 70,    // 70% aprobados
            'pendiente' => 15,   // 15% pendientes
            'fallido' => 10,     // 10% fallidos
            'reembolsado' => 5   // 5% reembolsados
        ];

        $pagos = [];

        // ==========================================
        // 1. PAGOS DE HOY (30 pagos)
        // ==========================================
        $this->command->info("📅 Generando pagos de HOY...");
        
        for ($i = 0; $i < 30; $i++) {
            $estado = $this->getEstadoPonderado($estados);
            $isProcessed = in_array($estado, ['aprobado', 'reembolsado']);
            
            // Distribuir pagos a lo largo del día
            $horaAleatoria = rand(0, 23);
            $minutoAleatorio = rand(0, 59);
            
            $paidAt = $isProcessed
                ? Carbon::today()->addHours($horaAleatoria)->addMinutes($minutoAleatorio)
                : null;

            $monto = $this->generarMontoRealista();

            $pagos[] = [
                'orden_id' => $ordenes[array_rand($ordenes)],
                'proveedor' => $proveedores[array_rand($proveedores)],
                'monto' => $monto,
                'moneda' => 'COP',
                'estado' => $estado,
                'aut_code' => $isProcessed ? strtoupper(Str::random(12)) : null,
                'trans_id_ext' => $isProcessed ? 'TRX-' . strtoupper(Str::random(10)) : null,
                'paid_at' => $paidAt,
                'created_at' => $paidAt ?? $now,
                'updated_at' => $now,
            ];
        }

        // ==========================================
        // 2. PAGOS DE AYER (25 pagos)
        // ==========================================
        $this->command->info("📅 Generando pagos de AYER...");
        
        for ($i = 0; $i < 25; $i++) {
            $estado = $this->getEstadoPonderado($estados);
            $isProcessed = in_array($estado, ['aprobado', 'reembolsado']);
            
            $horaAleatoria = rand(0, 23);
            $minutoAleatorio = rand(0, 59);
            
            $paidAt = $isProcessed
                ? Carbon::yesterday()->addHours($horaAleatoria)->addMinutes($minutoAleatorio)
                : null;

            $monto = $this->generarMontoRealista();

            $pagos[] = [
                'orden_id' => $ordenes[array_rand($ordenes)],
                'proveedor' => $proveedores[array_rand($proveedores)],
                'monto' => $monto,
                'moneda' => 'COP',
                'estado' => $estado,
                'aut_code' => $isProcessed ? strtoupper(Str::random(12)) : null,
                'trans_id_ext' => $isProcessed ? 'TRX-' . strtoupper(Str::random(10)) : null,
                'paid_at' => $paidAt,
                'created_at' => $paidAt ?? Carbon::yesterday(),
                'updated_at' => $now,
            ];
        }

        // ==========================================
        // 3. PAGOS HISTÓRICOS (últimos 30 días)
        // ==========================================
        $this->command->info("📅 Generando pagos históricos (30 días)...");
        
        for ($i = 0; $i < 200; $i++) {
            $estado = $this->getEstadoPonderado($estados);
            $isProcessed = in_array($estado, ['aprobado', 'reembolsado']);
            
            // Días atrás aleatorios (de 2 a 30 días)
            $diasAtras = rand(2, 30);
            $horaAleatoria = rand(0, 23);
            $minutoAleatorio = rand(0, 59);
            
            $paidAt = $isProcessed
                ? Carbon::now()->subDays($diasAtras)->addHours($horaAleatoria)->addMinutes($minutoAleatorio)
                : null;

            $monto = $this->generarMontoRealista();

            $pagos[] = [
                'orden_id' => $ordenes[array_rand($ordenes)],
                'proveedor' => $proveedores[array_rand($proveedores)],
                'monto' => $monto,
                'moneda' => 'COP',
                'estado' => $estado,
                'aut_code' => $isProcessed ? strtoupper(Str::random(12)) : null,
                'trans_id_ext' => $isProcessed ? 'TRX-' . strtoupper(Str::random(10)) : null,
                'paid_at' => $paidAt,
                'created_at' => $paidAt ?? Carbon::now()->subDays($diasAtras),
                'updated_at' => $now,
            ];
        }

        // Insertar todos los pagos
        DB::table('pago')->insert($pagos);

        // Estadísticas
        $totalPagos = count($pagos);
        $pagosAprobados = collect($pagos)->where('estado', 'aprobado')->count();
        $ingresoTotal = collect($pagos)->where('estado', 'aprobado')->sum('monto');
        
        $this->command->info("✅ Total de pagos generados: {$totalPagos}");
        $this->command->info("✅ Pagos aprobados: {$pagosAprobados}");
        $this->command->info("✅ Ingreso total simulado: $" . number_format($ingresoTotal, 0, ',', '.') . " COP");
    }

    /**
     * Generar monto realista para entrada de parque
     * Basado en precios de planes: General (100K), VIP (200K), Pro (300K)
     */
    private function generarMontoRealista(): int
    {
        $tiposPago = [
            50000,   // Ticket individual básico
            100000,  // Plan General
            120000,  // General + extras
            150000,  // Promoción familiar
            200000,  // Plan VIP
            250000,  // VIP + extras
            300000,  // Plan Pro
            350000,  // Pro + extras
            400000,  // Grupo familiar completo
            500000,  // Evento especial
        ];

        return $tiposPago[array_rand($tiposPago)];
    }

    /**
     * Obtener estado con distribución ponderada
     */
    private function getEstadoPonderado(array $estados): string
    {
        $rand = rand(1, 100);
        $acumulado = 0;

        foreach ($estados as $estado => $probabilidad) {
            $acumulado += $probabilidad;
            if ($rand <= $acumulado) {
                return $estado;
            }
        }

        return 'aprobado';
    }
}

