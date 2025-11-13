<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdenSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener clientes existentes
        $clientes = DB::table('cliente')->pluck('id')->toArray();

        if (empty($clientes)) {
            dd("⚠ No hay clientes para generar órdenes.");
        }

        $estados = ['pagada', 'pendiente', 'cancelada', 'fallida'];
        $canales = ['web', 'app', 'taquilla', 'caja_rapida'];

        $ordenes = [];

        for ($i = 1; $i <= 100; $i++) {

            $ordenes[] = [
                'cliente_id' => $clientes[array_rand($clientes)],
                'numero_orden' => 'ORD-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'estado' => $estados[array_rand($estados)],
                'total' => rand(50000, 350000),
                'canal' => $canales[array_rand($canales)],
                'ip_cliente' => "192.168." . rand(0, 255) . "." . rand(1, 254),
                'created_at' => $now->copy()->subMinutes(rand(0, 20000)),
                'updated_at' => $now,
            ];
        }

        DB::table('orden')->insert($ordenes);
    }
}
