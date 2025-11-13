<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        DB::table('cliente')->upsert([
            ['email' => 'cliente1@example.com', 'nombre' => 'Cliente Uno', 'telefono' => '+57 3000000001', 'pais' => 'Colombia', 'created_at' => $now, 'updated_at' => $now],
            ['email' => 'cliente2@example.com', 'nombre' => 'Cliente Dos', 'telefono' => '+57 3000000002', 'pais' => 'Colombia', 'created_at' => $now, 'updated_at' => $now],
        ], ['email'], ['nombre', 'telefono', 'pais', 'updated_at']);
    }
}
