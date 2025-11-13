<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TareaOperativaSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener IDs existentes
        $atractivos = DB::table('atraccion')->pluck('id')->toArray();
        $usuarios = DB::table('users')->pluck('id')->toArray();

        if (empty($atractivos) || empty($usuarios)) {
            dd("⚠ No existen atracciones o usuarios para generar tareas operativas.");
        }

        $titulos = [
            'Inspección de cinturones de seguridad',
            'Revisión de panel de control',
            'Limpieza de carros de la atracción',
            'Verificación de sensores de movimiento',
            'Inspección de estructura metálica',
            'Reporte de ruido inusual',
            'Revisión de cámaras de seguridad',
            'Calibración de frenos',
            'Mantenimiento del sistema hidráulico',
            'Actualización de software de control',
            'Revisión de luces LED',
            'Cambio de baterías de emergencia',
        ];

        $prioridades = [
            'baja',
            'media',
            'alta',
            'crítica'
        ];

        $estados = [
            'pendiente',
            'en progreso',
            'completada',
            'retrasada',
            'cancelada'
        ];

        $origenes = [
            'sistema',
            'operador',
            'mantenimiento',
            'incidente',
            'supervisor'
        ];

        $tareas = [];

        for ($i = 0; $i < 120; $i++) {

            $tareas[] = [
                'atractivo_id' => $atractivos[array_rand($atractivos)],
                'asignada_a' => $usuarios[array_rand($usuarios)],
                'titulo' => $titulos[array_rand($titulos)],
                'prioridad' => $prioridades[array_rand($prioridades)],
                'estado' => $estados[array_rand($estados)],
                'sla_horas' => rand(2, 48),
                'origen' => $origenes[array_rand($origenes)],
                'vencimiento_at' => now()->addDays(rand(0, 10))->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('tarea_operativa')->insert($tareas);
    }
}
