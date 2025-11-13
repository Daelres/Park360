<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $password = Hash::make('password123');

        $baseUsers = [
            [
                'email' => 'admin@park360.test',
                'name' => 'Administrador Park360',
                'estado' => 'activo',
                'ultimo_login' => null,
                'password' => $password,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'email' => 'operador@park360.test',
                'name' => 'Operador Park360',
                'estado' => 'activo',
                'ultimo_login' => null,
                'password' => $password,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'email' => 'ventas@park360.test',
                'name' => 'Ventas Park360',
                'estado' => 'activo',
                'ultimo_login' => null,
                'password' => $password,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'email' => 'cliente@park360.test',
                'name' => 'Cliente Park360',
                'estado' => 'activo',
                'ultimo_login' => null,
                'password' => $password,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('users')->upsert(
            $baseUsers,
            ['email'],
            ['name', 'estado', 'ultimo_login', 'password', 'email_verified_at', 'updated_at']
        );

        for ($i = 1; $i <= 100; $i++) {
            $email = "user{$i}@example.com";

            $attributes = [
                'name' => "Usuario {$i}",
                'estado' => rand(0, 1) ? 'activo' : 'inactivo',
                'ultimo_login' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
            'password' => $password,
                'email_verified_at' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
                'updated_at' => now(),
            ];

            if (! DB::table('users')->where('email', $email)->exists()) {
                $attributes['created_at'] = $now;
            }

            DB::table('users')->updateOrInsert(
                ['email' => $email],
                $attributes
            );
        }
    }
}
