<?php

namespace Database\Seeders;

use App\Models\TicketType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TicketTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'General Diario',
                'description' => 'Acceso a todas las atracciones durante un día.',
                'price' => 120000,
                'validity_days' => 1,
            ],
            [
                'name' => 'VIP Experiencia',
                'description' => 'Acceso prioritario y experiencia VIP.',
                'price' => 220000,
                'validity_days' => 1,
            ],
            [
                'name' => 'Pase Familiar',
                'description' => 'Entrada para 4 personas con descuento.',
                'price' => 400000,
                'validity_days' => 1,
            ],
        ];

        foreach ($types as $type) {
            TicketType::query()->updateOrCreate(
                ['slug' => Str::slug($type['name'])],
                array_merge($type, ['slug' => Str::slug($type['name'])])
            );
        }
    }
}
