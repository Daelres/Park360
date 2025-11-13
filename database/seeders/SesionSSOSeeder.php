<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SesionSSOSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener usuarios válidos
        $usuarios = DB::table('users')->pluck('id')->toArray();

        if (empty($usuarios)) {
            dd("⚠ No existen usuarios para generar sesiones SSO.");
        }

        $proveedores = [
            'google',
            'facebook',
            'microsoft',
            'github',
            'apple'
        ];

        $sesiones = [];
        $combinaciones = [];

        for ($i = 0; $i < 120; $i++) {

            $usuario = $usuarios[array_rand($usuarios)];
            $proveedor = $proveedores[array_rand($proveedores)];

            // Evitar duplicados usuario + proveedor (por el índice)
            $key = $usuario . '-' . $proveedor;
            if (isset($combinaciones[$key])) {
                continue;
            }
            $combinaciones[$key] = true;

            $expAt = now()->addHours(rand(1, 48));

            $sesiones[] = [
                'usuario_id'    => $usuario,
                'proveedor'     => $proveedor,
                'oidc_sub'      => Str::uuid(),
                'exp_at'        => $expAt,
                'refresh_token' => rand(0, 1) ? Str::random(40) : null,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];

            // Detener cuando tengamos 120 registros válidos
            if (count($sesiones) >= 120) {
                break;
            }
        }

        DB::table('sesion_s_s_o')->insert($sesiones);
    }
}
