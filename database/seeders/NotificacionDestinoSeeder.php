<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NotificacionDestinoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Notificaciones ya insertadas
        $notificaciones = DB::table('notificacion')->pluck('id')->toArray();

        // Correos existentes de clientes
        $correosClientes = DB::table('cliente')->pluck('email')->toArray();

        if (empty($notificaciones)) {
            dd("⚠ No existen notificaciones para generar destinos.");
        }

        if (empty($correosClientes)) {
            dd("⚠ No existen clientes para asignar como destinatarios.");
        }

        $estadosEnvio = ['enviado', 'pendiente', 'fallido'];

        $rows = [];

        for ($i = 0; $i < 100; $i++) {

            $estado = $estadosEnvio[array_rand($estadosEnvio)];
            $sentAt = null;
            $proveedorId = null;
            $retry = 0;

            // Si fue enviado, registrar fecha y proveedor
            if ($estado === 'enviado') {
                $sentAt = now()->subMinutes(rand(10, 5000));
                $proveedorId = 'msg-' . Str::random(6);
            }

            // Si falló, aumentar contador de reintentos
            if ($estado === 'fallido') {
                $retry = rand(1, 3);
            }

            $rows[] = [
                'notificacion_id' => $notificaciones[array_rand($notificaciones)],
                'destinatario_email' => $correosClientes[array_rand($correosClientes)],
                'estado_envio' => $estado,
                'proveedor_msg_id' => $proveedorId,
                'sent_at' => $sentAt,
                'retry_count' => $retry,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('notificacion_destino')->insert($rows);
    }
}
