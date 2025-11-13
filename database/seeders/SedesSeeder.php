<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SedesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $sedes = [
            [
                'codigo' => 'SED-001',
                'nombre' => 'Oasis Familiar - Ibagué',
                'ciudad' => 'Ibagué',
                'direccion' => 'Calle 53 # 28-60',
                'telefono' => '+57 3632418046',
                'correo_contacto' => 'contacto1@sedespark360.com',
                'descripcion' => 'Sede ubicada en Ibagué especializada en entretenimiento y actividades familiares.',
                'gerente' => 'Gerente Ibagué',
            ],
            [
                'codigo' => 'SED-002',
                'nombre' => 'Montaña Mágica - Cali',
                'ciudad' => 'Cali',
                'direccion' => 'Calle 86 # 35-01',
                'telefono' => '+57 3384152686',
                'correo_contacto' => 'contacto2@sedespark360.com',
                'descripcion' => 'Sede ubicada en Cali especializada en entretenimiento y actividades familiares.',
                'gerente' => 'Gerente Cali',
            ],
            [
                'codigo' => 'SED-003',
                'nombre' => 'EcoAventura - Bogotá',
                'ciudad' => 'Bogotá',
                'direccion' => 'Calle 140 # 50-69',
                'telefono' => '+57 3948285246',
                'correo_contacto' => 'contacto3@sedespark360.com',
                'descripcion' => 'Sede ubicada en Bogotá especializada en entretenimiento y actividades familiares.',
                'gerente' => 'Gerente Bogotá',
            ],
            [
                'codigo' => 'SED-004',
                'nombre' => 'Oasis Familiar - Barranquilla',
                'ciudad' => 'Barranquilla',
                'direccion' => 'Calle 84 # 49-41',
                'telefono' => '+57 3159387635',
                'correo_contacto' => 'contacto4@sedespark360.com',
                'descripcion' => 'Sede ubicada en Barranquilla especializada en entretenimiento y actividades familiares.',
                'gerente' => 'Gerente Barranquilla',
            ],
            [
                'codigo' => 'SED-005',
                'nombre' => 'Montaña Mágica - Cúcuta',
                'ciudad' => 'Cúcuta',
                'direccion' => 'Calle 63 # 21-75',
                'telefono' => '+57 3246680526',
                'correo_contacto' => 'contacto5@sedespark360.com',
                'descripcion' => 'Sede ubicada en Cúcuta especializada en entretenimiento y actividades familiares.',
                'gerente' => 'Gerente Cúcuta',
            ],
            [
                'codigo' => 'SED-006',
                'nombre' => 'Mundo Aventura - Medellín',
                'ciudad' => 'Medellín',
                'direccion' => 'Calle 26 # 8-85',
                'telefono' => '+57 3444899707',
                'correo_contacto' => 'contacto6@sedespark360.com',
                'descripcion' => 'Sede ubicada en Medellín especializada en entretenimiento y actividades familiares.',
                'gerente' => 'Gerente Medellín',
            ],
            [
                'codigo' => 'SED-007',
                'nombre' => 'EcoAventura - Pereira',
                'ciudad' => 'Pereira',
                'direccion' => 'Calle 53 # 6-39',
                'telefono' => '+57 3416789187',
                'correo_contacto' => 'contacto7@sedespark360.com',
                'descripcion' => 'Sede ubicada en Pereira especializada en entretenimiento y actividades familiares.',
                'gerente' => 'Gerente Pereira',
            ],
            [
                'codigo' => 'SED-008',
                'nombre' => 'Parque Extremo - Cartagena',
                'ciudad' => 'Cartagena',
                'direccion' => 'Calle 07 # 20-11',
                'telefono' => '+57 3238749184',
                'correo_contacto' => 'contacto8@sedespark360.com',
                'descripcion' => 'Sede ubicada en Cartagena especializada en entretenimiento y actividades familiares.',
                'gerente' => 'Gerente Cartagena',
            ],
            [
                'codigo' => 'SED-009',
                'nombre' => 'Mundo Aventura - Cali',
                'ciudad' => 'Cali',
                'direccion' => 'Calle 92 # 10-60',
                'telefono' => '+57 3600809220',
                'correo_contacto' => 'contacto9@sedespark360.com',
                'descripcion' => 'Segunda sede en Cali con entretenimiento familiar y experiencias temáticas.',
                'gerente' => 'Gerente Cali',
            ],
            [
                'codigo' => 'SED-010',
                'nombre' => 'Parque Central - Pereira',
                'ciudad' => 'Pereira',
                'direccion' => 'Calle 100 # 15-49',
                'telefono' => '+57 3109199967',
                'correo_contacto' => 'contacto10@sedespark360.com',
                'descripcion' => 'Sede con oferta familiar y espectáculos nocturnos.',
                'gerente' => 'Gerente Pereira',
            ],
            [
                'codigo' => 'SED-011',
                'nombre' => 'Explora Kids - Ibagué',
                'ciudad' => 'Ibagué',
                'direccion' => 'Calle 75 # 25-32',
                'telefono' => '+57 3797190136',
                'correo_contacto' => 'contacto11@sedespark360.com',
                'descripcion' => 'Centro educativo con atracciones para niños y talleres STEM.',
                'gerente' => 'Gerente Ibagué',
            ],
            [
                'codigo' => 'SED-012',
                'nombre' => 'Oasis Familiar - Cúcuta',
                'ciudad' => 'Cúcuta',
                'direccion' => 'Calle 07 # 28-71',
                'telefono' => '+57 3408135109',
                'correo_contacto' => 'contacto12@sedespark360.com',
                'descripcion' => 'Sede con enfoque en recreación familiar en climas cálidos.',
                'gerente' => 'Gerente Cúcuta',
            ],
            [
                'codigo' => 'SED-013',
                'nombre' => 'Montaña Mágica - Bogotá',
                'ciudad' => 'Bogotá',
                'direccion' => 'Calle 125 # 16-23',
                'telefono' => '+57 3141189242',
                'correo_contacto' => 'contacto13@sedespark360.com',
                'descripcion' => 'Sede con atracciones extremas y espectáculos nocturnos.',
                'gerente' => 'Gerente Bogotá',
            ],
            [
                'codigo' => 'SED-014',
                'nombre' => 'Aventura Andina - Manizales',
                'ciudad' => 'Manizales',
                'direccion' => 'Calle 01 # 12-60',
                'telefono' => '+57 3445754540',
                'correo_contacto' => 'contacto14@sedespark360.com',
                'descripcion' => 'Atracciones de montaña con experiencias de realidad virtual.',
                'gerente' => 'Gerente Manizales',
            ],
            [
                'codigo' => 'SED-015',
                'nombre' => 'Montaña Mágica - Cartagena',
                'ciudad' => 'Cartagena',
                'direccion' => 'Calle 71 # 21-85',
                'telefono' => '+57 3930781031',
                'correo_contacto' => 'contacto15@sedespark360.com',
                'descripcion' => 'Atracciones temáticas de aventura acuática y espectáculos nocturnos.',
                'gerente' => 'Gerente Cartagena',
            ],
            [
                'codigo' => 'SED-016',
                'nombre' => 'Zona Caribe - Medellín',
                'ciudad' => 'Medellín',
                'direccion' => 'Calle 02 # 18-48',
                'telefono' => '+57 3146957889',
                'correo_contacto' => 'contacto16@sedespark360.com',
                'descripcion' => 'Experiencias inmersivas con ambientación tropical.',
                'gerente' => 'Gerente Medellín',
            ],
            [
                'codigo' => 'SED-017',
                'nombre' => 'Oasis Familiar - Medellín',
                'ciudad' => 'Medellín',
                'direccion' => 'Calle 122 # 48-45',
                'telefono' => '+57 3261387117',
                'correo_contacto' => 'contacto17@sedespark360.com',
                'descripcion' => 'Zona enfocada en familias y primeras experiencias de atracciones.',
                'gerente' => 'Gerente Medellín',
            ],
            [
                'codigo' => 'SED-018',
                'nombre' => 'Oasis Familiar - Pereira',
                'ciudad' => 'Pereira',
                'direccion' => 'Calle 150 # 46-45',
                'telefono' => '+57 3644414414',
                'correo_contacto' => 'contacto18@sedespark360.com',
                'descripcion' => 'Complejo familiar con espectáculos interactivos.',
                'gerente' => 'Gerente Pereira',
            ],
            [
                'codigo' => 'SED-019',
                'nombre' => 'Mundo Aventura - Cartagena',
                'ciudad' => 'Cartagena',
                'direccion' => 'Calle 114 # 21-72',
                'telefono' => '+57 3332624047',
                'correo_contacto' => 'contacto19@sedespark360.com',
                'descripcion' => 'Sede con atracciones tecnológicas y espectáculos acuáticos.',
                'gerente' => 'Gerente Cartagena',
            ],
            [
                'codigo' => 'SED-020',
                'nombre' => 'Costa Diversión - Barranquilla',
                'ciudad' => 'Barranquilla',
                'direccion' => 'Calle 89 # 45-55',
                'telefono' => '+57 3222427936',
                'correo_contacto' => 'contacto20@sedespark360.com',
                'descripcion' => 'Sede costera con fuerte oferta gastronómica y shows culturales.',
                'gerente' => 'Gerente Barranquilla',
            ],
        ];

        $payload = array_map(static function (array $sede) use ($now) {
            return array_merge($sede, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $sedes);

        DB::table('sedes')->upsert(
            $payload,
            ['codigo'],
            ['nombre', 'ciudad', 'direccion', 'telefono', 'correo_contacto', 'descripcion', 'gerente', 'updated_at']
        );
    }
}
