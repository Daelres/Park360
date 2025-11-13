<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $nombresBase = [
            'Daniel', 'María', 'Camilo', 'Laura', 'Sebastián', 'Ana', 'Mateo', 'Carolina',
            'Andrés', 'Valentina', 'Juan', 'Luisa', 'Felipe', 'Sofía', 'Julián', 'Gabriela',
            'Simón', 'Natalia', 'Esteban', 'Manuela'
        ];

        $apellidosBase = [
            'Gómez', 'Rodríguez', 'Martínez', 'Restrepo', 'Hernández', 'López', 'Torres',
            'Ramírez', 'Sánchez', 'Castro', 'Pérez', 'Vargas', 'Cárdenas', 'Moreno'
        ];

        $paises = ['Colombia', 'México', 'Argentina', 'Chile', 'Perú', 'Ecuador', 'Brasil'];

        $clientes = [];

        for ($i = 1; $i <= 100; $i++) {

            $nombre = $nombresBase[array_rand($nombresBase)] . ' ' . $apellidosBase[array_rand($apellidosBase)];

            $clientes[] = [
                'email' => "cliente$i@example.com",
                'nombre' => $nombre,
                'telefono' => '+57 3' . rand(100000000, 999999999),
                'pais' => $paises[array_rand($paises)],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('cliente')->insert($clientes);
    }
}
