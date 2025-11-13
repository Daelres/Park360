<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $usuarios = DB::table('users')->pluck('id', 'email');
        $roles = DB::table('rol')->pluck('id', 'nombre');

        $rows = [];
        if (isset($usuarios['admin@park360.test'], $roles['admin'])) {
            $rows[] = [
                'usuario_id' => $usuarios['admin@park360.test'],
                'rol_id' => $roles['admin'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (isset($usuarios['operador@park360.test'], $roles['employee'])) {
            $rows[] = [
                'usuario_id' => $usuarios['operador@park360.test'],
                'rol_id' => $roles['employee'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (isset($usuarios['ventas@park360.test'], $roles['employee'])) {
            $rows[] = [
                'usuario_id' => $usuarios['ventas@park360.test'],
                'rol_id' => $roles['employee'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (isset($usuarios['cliente@park360.test'], $roles['client'])) {
            $rows[] = [
                'usuario_id' => $usuarios['cliente@park360.test'],
                'rol_id' => $roles['client'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            DB::table('user_rol')->upsert($rows, ['usuario_id', 'rol_id'], ['updated_at']);
        }
    }
}
