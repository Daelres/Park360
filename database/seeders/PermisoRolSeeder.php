<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoRolSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $roles = DB::table('rol')->pluck('id', 'nombre');
        $permisos = DB::table('permiso')->pluck('id', 'nombre');

        $pairs = [];
        // admin: todos
        foreach ($permisos as $permisoNombre => $permisoId) {
            if (isset($roles['admin'])) {
                $pairs[] = [
                    'permiso_id' => $permisoId,
                    'rol_id' => $roles['admin'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        // operador: operar_atracciones, ver_dashboard
        foreach (['operar_atracciones', 'ver_dashboard'] as $p) {
            if (isset($permisos[$p], $roles['operador'])) {
                $pairs[] = [
                    'permiso_id' => $permisos[$p],
                    'rol_id' => $roles['operador'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }
        // ventas: gestionar_ventas, ver_dashboard
        foreach (['gestionar_ventas', 'ver_dashboard'] as $p) {
            if (isset($permisos[$p], $roles['ventas'])) {
                $pairs[] = [
                    'permiso_id' => $permisos[$p],
                    'rol_id' => $roles['ventas'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('permiso_rol')->insert($pairs);
    }
}
