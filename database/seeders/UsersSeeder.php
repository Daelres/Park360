<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $users = [];

        for ($i = 1; $i <= 100; $i++) {

            $users[] = [
                'email' => "user{$i}@example.com",
                'name' => "Usuario {$i}",
                'estado' => rand(0, 1) ? 'activo' : 'inactivo',
                'ultimo_login' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
                'password' => Hash::make('password123'),
                'email_verified_at' => rand(0, 1) ? now()->subDays(rand(1, 30)) : null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('users')->insert($users);
    }
}
