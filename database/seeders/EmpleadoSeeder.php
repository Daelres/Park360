<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EmpleadoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        if (!Schema::hasTable('users')) {
            dd("⚠ Tabla 'users' no existe. Revisa tus migraciones (¿usaste 'usuarios' en vez de 'users'?).");
        }

        if (!Schema::hasTable('empleado')) {
            dd("⚠ Tabla 'empleados' no existe. Revisa el nombre de la tabla en la migración.");
        }

        $usuarios = DB::table('users')->pluck('id')->toArray();

        if (empty($usuarios)) {
            dd("⚠ No existen usuarios para asociar empleados. Ejecuta primero los seeders de usuarios.");
        }

        $cargos = [
            'Operador', 'Cajero', 'Supervisor', 'Mecánico', 'Atención al Cliente',
            'Seguridad', 'Administrador', 'Auxiliar Técnico', 'Taquillero',
            'Coordinador de Atracción'
        ];

        $areas = [
            'Atracciones', 'Ventas', 'Operaciones', 'Mantenimiento',
            'Seguridad', 'Administración', 'Servicios Generales'
        ];

        $empleados = [];

        for ($i = 1; $i <= 100; $i++) {
            $empleados[] = [
                'usuario_id' => $usuarios[array_rand($usuarios)],
                'documento' => 'EMP-' . str_pad($i + 1000, 5, '0', STR_PAD_LEFT),
                'cargo' => $cargos[array_rand($cargos)],
                'area' => $areas[array_rand($areas)],
                'fecha_ingreso' => now()->subDays(rand(30, 1500))->toDateString(),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('empleado')->insert($empleados);
    }
}
