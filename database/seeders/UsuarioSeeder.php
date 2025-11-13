<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $users = [
            [
                'name' => 'Admin Principal',
                'email' => 'admin@park360.test',
                'estado' => 'activo',
                'ultimo_login' => null,
            ],
            [
                'name' => 'Operador Parque',
                'email' => 'operador@park360.test',
                'estado' => 'activo',
                'ultimo_login' => null,
            ],
            [
                'name' => 'Operador Ventas',
                'email' => 'ventas@park360.test',
                'estado' => 'activo',
                'ultimo_login' => null,
            ],
        ];

        foreach ($users as $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'estado' => $user['estado'],
                    'ultimo_login' => $user['ultimo_login'],
                    'password' => Hash::make('secret'),
                    'email_verified_at' => $now,
                ]
            );
        }
    }
}
