<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdenSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $clientes = DB::table('cliente')->pluck('id', 'email');

        DB::table('orden')->upsert([
            [
                'cliente_id' => $clientes['cliente1@example.com'] ?? 1,
                'numero_orden' => 'ORD-10001',
                'estado' => 'pagada',
                'total' => 150000,
                'canal' => 'web',
                'ip_cliente' => '127.0.0.1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'cliente_id' => $clientes['cliente2@example.com'] ?? 1,
                'numero_orden' => 'ORD-10002',
                'estado' => 'pendiente',
                'total' => 90000,
                'canal' => 'taquilla',
                'ip_cliente' => '127.0.0.1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ], ['numero_orden'], ['cliente_id', 'estado', 'total', 'canal', 'ip_cliente', 'updated_at']);
    }
}
