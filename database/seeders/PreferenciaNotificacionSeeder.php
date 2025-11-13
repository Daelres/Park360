<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferenciaNotificacionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $usuarios = DB::table('users')->pluck('id', 'email');
        $clientes = DB::table('cliente')->pluck('id', 'email');

        $rows = [];
        if (isset($usuarios['admin@park360.test'])) {
            $rows[] = [
                'user_id' => $usuarios['admin@park360.test'],
                'cliente_id' => null,
                'canal_email' => true,
                'horario_silencio' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (isset($usuarios['ventas@park360.test'], $clientes['cliente1@example.com'])) {
            $rows[] = [
                'user_id' => $usuarios['ventas@park360.test'],
                'cliente_id' => $clientes['cliente1@example.com'],
                'canal_email' => true,
                'horario_silencio' => '22:00-07:00',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            DB::table('preferencia_notificacion')->upsert(
                $rows,
                ['user_id', 'cliente_id'],
                ['canal_email', 'horario_silencio', 'updated_at']
            );
        }
    }
}
