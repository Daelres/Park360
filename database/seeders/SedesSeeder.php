<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SedesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $ciudades = [
            'Bogotá', 'Medellín', 'Cali', 'Barranquilla', 'Bucaramanga',
            'Cartagena', 'Manizales', 'Pereira', 'Cúcuta', 'Ibagué'
        ];

        $nombresSede = [
            'Parque Central',
            'Parque Extremo',
            'Aventura Andina',
            'Zona Caribe',
            'Montaña Mágica',
            'Oasis Familiar',
            'Costa Diversión',
            'Mundo Aventura',
            'Explora Kids',
            'EcoAventura'
        ];

        $sedes = [];

        for ($i = 1; $i <= 20; $i++) {

            $ciudad = $ciudades[array_rand($ciudades)];
            $nombre = $nombresSede[array_rand($nombresSede)] . " - " . $ciudad;

            $sedes[] = [
                'codigo'          => 'SED-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nombre'          => $nombre,
                'ciudad'          => $ciudad,
                'direccion'       => 'Calle ' . rand(1, 150) . ' # ' . rand(1, 50) . '-' . rand(1, 90),
                'telefono'        => '+57 3' . rand(100000000, 999999999),
                'correo_contacto' => 'contacto' . $i . '@sedespark360.com',
                'descripcion'     => 'Sede ubicada en ' . $ciudad . ' especializada en entretenimiento y actividades familiares.',
                'gerente'         => 'Gerente ' . $ciudad,
                'created_at'      => $now,
                'updated_at'      => $now,
            ];
        }

        DB::table('sedes')->insert($sedes);
    }
}
