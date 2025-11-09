<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificacionDestinoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $noti = DB::table('notificacion')->pluck('id', 'tipo');

        $rows = [];
        if (isset($noti['bienvenida'])) {
            $rows[] = [
                'notificacion_id' => $noti['bienvenida'],
                'destinatario_email' => 'cliente1@example.com',
                'estado_envio' => 'enviado',
                'proveedor_msg_id' => 'msg-001',
                'sent_at' => now()->subDay(),
                'retry_count' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (isset($noti['orden_pagada'])) {
            $rows[] = [
                'notificacion_id' => $noti['orden_pagada'],
                'destinatario_email' => 'cliente1@example.com',
                'estado_envio' => 'pendiente',
                'proveedor_msg_id' => null,
                'sent_at' => null,
                'retry_count' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            DB::table('notificacion_destino')->insert($rows);
        }
    }
}
