<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificacionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        DB::table('notificacion')->insert([
            [
                'tipo' => 'bienvenida',
                'origen' => 'sistema',
                'payload' => json_encode(['subject' => 'Bienvenido a Park360', 'message' => 'Gracias por registrarte.']),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'tipo' => 'orden_pagada',
                'origen' => 'ventas',
                'payload' => json_encode(['numero_orden' => 'ORD-10001', 'total' => 150000]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
