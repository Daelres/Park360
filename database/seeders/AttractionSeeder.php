<?php

namespace Database\Seeders;

use App\Models\Attraction;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class AttractionSeeder extends Seeder
{
    public function run(): void
    {
        $attractions = [
            [
                'name' => 'Montaña Cósmica',
                'description' => 'Montaña rusa principal del parque con loops y efectos de luz.',
                'status' => 'active',
                'capacity' => 24,
                'location' => 'Zona A',
                'opening_time' => '09:00',
                'closing_time' => '19:00',
                'safety_score' => 9,
            ],
            [
                'name' => 'Río Aventura',
                'description' => 'Recorrido acuático familiar con rápidos y efectos especiales.',
                'status' => 'maintenance',
                'capacity' => 30,
                'location' => 'Zona B',
                'opening_time' => '10:00',
                'closing_time' => '18:30',
                'safety_score' => 7,
            ],
            [
                'name' => 'Torre de Caída Libre',
                'description' => 'Atracción de caída libre con vista panorámica.',
                'status' => 'active',
                'capacity' => 16,
                'location' => 'Zona C',
                'opening_time' => '11:00',
                'closing_time' => '20:00',
                'safety_score' => 8,
            ],
            [
                'name' => 'Carrusel Galáctico',
                'description' => 'Carrusel infantil con temática espacial.',
                'status' => 'active',
                'capacity' => 40,
                'location' => 'Zona Infantil',
                'opening_time' => '09:00',
                'closing_time' => '21:00',
                'safety_score' => 10,
            ],
            [
                'name' => 'Simulador 360',
                'description' => 'Simulador de realidad virtual inmersivo para grupos.',
                'status' => 'closed',
                'capacity' => 12,
                'location' => 'Zona Tech',
                'opening_time' => '12:00',
                'closing_time' => '22:00',
                'safety_score' => 6,
            ],
        ];

        $employees = Employee::query()->pluck('id')->toArray();

        foreach ($attractions as $data) {
            $attraction = Attraction::query()->updateOrCreate(
                ['name' => $data['name']],
                $data
            );

            if ($employees) {
                $attraction->employees()->sync(array_slice($employees, 0, min(2, count($employees))));
            }

            if (! $attraction->incidents()->exists()) {
                $attraction->incidents()->create([
                    'title' => 'Revisión inicial',
                    'description' => 'Registro inicial de incidentes para control de calidad.',
                    'severity' => 'low',
                    'status' => 'closed',
                    'reported_at' => now()->subDays(rand(5, 20)),
                    'resolved_at' => now()->subDays(rand(1, 4)),
                ]);
            }
        }
    }
}
