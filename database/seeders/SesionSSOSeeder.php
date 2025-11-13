<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SesionSSOSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $usuarios = DB::table('users')->pluck('id', 'email');

        $rows = [];
        if (isset($usuarios['admin@park360.test'])) {
            $rows[] = [
                'user_id' => $usuarios['admin@park360.test'],
                'proveedor' => 'keycloak',
                'oidc_sub' => 'sub-admin-demo',
                'exp_at' => now()->addHours(2),
                'refresh_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (isset($usuarios['operador@park360.test'])) {
            $rows[] = [
                'user_id' => $usuarios['operador@park360.test'],
                'proveedor' => 'keycloak',
                'oidc_sub' => 'sub-operador-demo',
                'exp_at' => now()->addHours(2),
                'refresh_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            DB::table('sesion_s_s_o')->upsert($rows, ['user_id', 'proveedor'], ['oidc_sub', 'exp_at', 'refresh_token', 'updated_at']);
        }
    }
}
