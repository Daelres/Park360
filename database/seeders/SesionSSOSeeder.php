<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SesionSSOSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $usuarios = DB::table('usuarios')->pluck('id', 'email');

        $rows = [];
        if (isset($usuarios['admin@park360.test'])) {
            $rows[] = [
                'usuario_id' => $usuarios['admin@park360.test'],
                'proveedor' => 'keycloak',
                'oidc_sub' => 'sub-admin-'.uniqid(),
                'exp_at' => now()->addHours(2),
                'refresh_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if (isset($usuarios['operador@park360.test'])) {
            $rows[] = [
                'usuario_id' => $usuarios['operador@park360.test'],
                'proveedor' => 'keycloak',
                'oidc_sub' => 'sub-operador-'.uniqid(),
                'exp_at' => now()->addHours(2),
                'refresh_token' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (!empty($rows)) {
            DB::table('sesion_s_s_o')->insert($rows);
        }
    }
}
