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
                'user_id' => $usuarios['admin@park360.test'],
                'rol_id' => $roles['admin'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (isset($usuarios['operador@park360.test'], $roles['operador'])) {
            $rows[] = [
                'user_id' => $usuarios['operador@park360.test'],
                'rol_id' => $roles['operador'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (isset($usuarios['ventas@park360.test'], $roles['ventas'])) {
            $rows[] = [
                'user_id' => $usuarios['ventas@park360.test'],
                'rol_id' => $roles['ventas'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            DB::table('user_rol')->upsert($rows, ['user_id', 'rol_id'], ['updated_at']);
        }
    }
}
