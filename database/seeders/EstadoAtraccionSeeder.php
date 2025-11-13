<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoAtraccionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener IDs válidos
        $atracciones = DB::table('atraccion')->pluck('id')->toArray();
        $usuarios = DB::table('users')->pluck('id')->toArray();

        if (empty($atracciones) || empty($usuarios)) {
            dd("⚠ No existen atracciones o usuarios para generar estados.");
        }

        $estados = [
            'operativa',
            'mantenimiento',
            'cerrada temporalmente',
            'inspección',
            'evento especial'
        ];

        $motivos = [
            'Mantenimiento programado',
            'Falla mecánica reportada',
            'Revisión de seguridad',
            'Evento especial de temporada',
            'Limpieza profunda',
            'Actualización técnica del sistema',
            'Ruido estructural inusual detectado',
            'Reporte de operador',
            null,
        ];

        $registros = [];

        for ($i = 0; $i < 50; $i++) {

            // Fecha desde aleatoria (últimos 30 días)
            $desde = now()
                ->subDays(rand(1, 30))
                ->subHours(rand(0, 12));

            // 40% de los registros quedan abiertos (sin fecha fin)
            if (rand(1, 100) <= 40) {
                $hasta = null;
            } else {
                $hasta = (clone $desde)->addHours(rand(1, 24));
            }

            $registros[] = [
                'atraccion_id' => $atracciones[array_rand($atracciones)],
                'estado' => $estados[array_rand($estados)],
                'desde' => $desde,
                'hasta' => $hasta,
                'motivo' => $motivos[array_rand($motivos)],
                'registrado_por_id' => $usuarios[array_rand($usuarios)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('estado_atraccion')->insert($registros);
    }
}
