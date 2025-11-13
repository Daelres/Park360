<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferenciaNotificacionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener usuarios y clientes válidos
        $usuarios = DB::table('users')->pluck('id')->toArray();
        $clientes = DB::table('cliente')->pluck('id')->toArray();

        if (empty($usuarios)) {
            dd("⚠ No existen usuarios para generar preferencias.");
        }

        $intervalosSilencio = [
            null,
            '22:00-06:00',
            '23:00-07:00',
            '00:00-08:00',
            '20:00-05:00'
        ];

        $registros = [];
        $combinaciones = [];

        for ($i = 0; $i < 100; $i++) {

            $usuario = $usuarios[array_rand($usuarios)];

            // 50% de probabilidad de asociar un cliente, o dejarlo como null
            $cliente = rand(1, 100) <= 50 ? ($clientes[array_rand($clientes)] ?? null) : null;

            // Evitar duplicados por la UNIQUE (usuario_id, cliente_id)
            $key = $usuario . '-' . ($cliente ?? 'null');
            if (isset($combinaciones[$key])) {
                continue; // evitar duplicados, saltar
            }
            $combinaciones[$key] = true;

            $registros[] = [
                'usuario_id' => $usuario,
                'cliente_id' => $cliente,
                'canal_email' => rand(0, 1),
                'horario_silencio' => $intervalosSilencio[array_rand($intervalosSilencio)],
                'created_at' => $now,
                'updated_at' => $now,
            ];

            // Si ya tenemos 100 registros, detener
            if (count($registros) >= 100) break;
        }

        DB::table('preferencia_notificacion')->insert($registros);
    }
}
