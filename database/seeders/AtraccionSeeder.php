<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtraccionSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $sedes = DB::table('sedes')->pluck('id')->toArray();

        $atracciones = [
            [
                'sede_id' => $sedes[0] ?? 1,
                'nombre' => 'Montaña Rusa Andina',
                'descripcion' => 'Una emocionante montaña rusa con vueltas y giros extremos. Ideal para amantes de la adrenalina.',
                'tipo' => 'Extrema',
                'capacidad' => 24,
                'altura_minima' => 140,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://images.unsplash.com/photo-1520880867055-1e30d1cb001c?auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[0] ?? 1,
                'nombre' => 'Río Lento Tropical',
                'descripcion' => 'Un tranquilo paseo en bote a través de un entorno tropical. Perfecto para familias.',
                'tipo' => 'Familiar',
                'capacidad' => 50,
                'altura_minima' => 100,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://images.unsplash.com/photo-1542317854-0d6bd4aea02b?auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[0] ?? 1,
                'nombre' => 'Rueda Panorámica',
                'descripcion' => 'Una hermosa rueda panorámica con vistas espectaculares del parque. Accesible para todas las edades.',
                'tipo' => 'Familiar',
                'capacidad' => 60,
                'altura_minima' => 0,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://images.unsplash.com/photo-1549887534-f0f58e9d13d4?auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[0] ?? 1,
                'nombre' => 'Casa del Terror Amazónico',
                'descripcion' => 'Una experiencia de horror interactiva con efectos especiales y actores. Adecuada para mayores de 13 años.',
                'tipo' => 'Interactiva/Tecnologica',
                'capacidad' => 30,
                'altura_minima' => 130,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[0] ?? 1,
                'nombre' => 'Splash Caribeño',
                'descripcion' => 'Un emocionante paseo acuático con salpicadas y caídas. Lleva traje de baño.',
                'tipo' => 'Familiar',
                'capacidad' => 40,
                'altura_minima' => 110,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://images.unsplash.com/photo-1559910780-b73d0b5b5d6c?auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[0] ?? 1,
                'nombre' => 'Tren de los Volcanes',
                'descripcion' => 'Un viaje en tren a través de un paisaje volcánico fantástico con efectos especiales.',
                'tipo' => 'Infantil',
                'capacidad' => 80,
                'altura_minima' => 90,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://images.unsplash.com/photo-1559411586-353f8f0ec9ea?auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[0] ?? 1,
                'nombre' => 'Torre del Vértigo',
                'descripcion' => 'Una emocionante caída libre desde una altura de 50 metros. Altamente emocionante.',
                'tipo' => 'Extrema',
                'capacidad' => 16,
                'altura_minima' => 145,
                'estado_operativo' => 'Mantenimiento',
                'imagen_url' => 'https://images.unsplash.com/photo-1502955691992-36f4c03a4d74?auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[0] ?? 1,
                'nombre' => 'Safari Jurásico',
                'descripcion' => 'Un viaje interactivo donde verás dinosaurios de realidad aumentada. Experiencia educativa y divertida.',
                'tipo' => 'Interactiva/Tecnologica',
                'capacidad' => 45,
                'altura_minima' => 110,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[0] ?? 1,
                'nombre' => 'Ciclón del Pacífico',
                'descripcion' => 'Un emocionante carrusel giratorio que aumenta la velocidad progresivamente. Para los valientes.',
                'tipo' => 'Extrema',
                'capacidad' => 36,
                'altura_minima' => 135,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://images.unsplash.com/photo-1566752881219-b62e3a4f2c45?auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[0] ?? 1,
                'nombre' => 'Vuelo del Cóndor',
                'descripcion' => 'Un simulador de vuelo que te lleva a través de paisajes montañosos. Experiencia inmersiva.',
                'tipo' => 'Interactiva/Tecnologica',
                'capacidad' => 32,
                'altura_minima' => 125,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://images.unsplash.com/photo-1569163139394-de4798aa62b1?auto=format&fit=crop&w=800&q=80',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('atraccion')->insert($atracciones);
    }
}
