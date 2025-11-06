<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonaSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        DB::table('zona')->insert([
            ['nombre' => 'Zona A', 'ubicacion' => 'Entrada Norte', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Zona B', 'ubicacion' => 'Sector Central', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Zona C', 'ubicacion' => 'Lago', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
