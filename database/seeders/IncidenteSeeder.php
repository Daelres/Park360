<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncidenteSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener IDs válidos
        $atracciones = DB::table('atraccion')->pluck('id')->toArray();
        $usuarios = DB::table('users')->pluck('id')->toArray();

        if (empty($atracciones) || empty($usuarios)) {
            dd("⚠ No existen atracciones o usuarios para generar incidentes.");
        }

        $tipos = [
            'Falla mecánica',
            'Corte de energía',
            'Reporte de seguridad',
            'Accidente menor',
            'Accidente mayor',
            'Comportamiento inapropiado',
            'Evacuación preventiva',
            'Sensor desactivado',
            'Ruidos anormales',
            'Revisión programada'
        ];

        $severidades = [
            'baja',
            'media',
            'alta',
            'crítica'
        ];

        $estados = [
            'abierto',
            'en progreso',
            'cerrado'
        ];

        $descripciones = [
            'Se detectó una vibración inusual en el motor.',
            'Un pasajero reportó que la barra de seguridad no cerró correctamente.',
            'El sistema automático registró una anomalía.',
            'Se realizó una evacuación preventiva por mal olor.',
            'Se presentó un corte de energía durante la operación.',
            'Un visitante sufrió una caída leve al bajar de la atracción.',
            'El personal reportó un comportamiento inapropiado de un usuario.',
            'El sistema de frenado tardó más de lo normal.',
            'Se generó un ruido extraño en la base de la estructura.',
            'Se activó una alarma de seguridad sin razón aparente.',
            null
        ];

        $registros = [];

        for ($i = 0; $i < 80; $i++) {

            // Fecha de inicio aleatoria en los últimos 60 días
            $inicio = now()
                ->subDays(rand(0, 60))
                ->subHours(rand(0, 10))
                ->subMinutes(rand(0, 59));

            // 40% de los incidentes quedan abiertos sin fin_at
            if (rand(1, 100) <= 40) {
                $fin = null;
            } else {
                $fin = (clone $inicio)->addHours(rand(1, 12));
            }

            $registros[] = [
                'atraccion_id' => $atracciones[array_rand($atracciones)],
                'reportado_por_id' => $usuarios[array_rand($usuarios)],
                'tipo' => $tipos[array_rand($tipos)],
                'severidad' => $severidades[array_rand($severidades)],
                'descripcion' => $descripciones[array_rand($descripciones)],
                'inicio_at' => $inicio,
                'fin_at' => $fin,
                'estado' => $estados[array_rand($estados)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('incidente')->insert($registros);
    }
}
