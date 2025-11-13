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
        
        if (empty($sedes)) {
            $sedes = [1]; // Fallback to ID 1 if no sedes exist
        }
        
        $sedeCount = count($sedes);

        $atracciones = [
            [
                'sede_id' => $sedes[0 % $sedeCount],
                'nombre' => 'Montaña Rusa Andina',
                'descripcion' => 'Una emocionante montaña rusa con vueltas y giros extremos. Ideal para amantes de la adrenalina.',
                'tipo' => 'Extrema',
                'capacidad' => 24,
                'altura_minima' => 140,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://www.lavanguardia.com/files/content_image_mobile_filter/files/fp/uploads/2021/05/01/608c81d1dd717.r_d.400-329.jpeg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[1 % $sedeCount],
                'nombre' => 'Río Lento Tropical',
                'descripcion' => 'Un tranquilo paseo en bote a través de un entorno tropical. Perfecto para familias.',
                'tipo' => 'Familiar',
                'capacidad' => 50,
                'altura_minima' => 100,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://parquenorte.gov.co/wp-content/uploads/2018/11/JUNGLA-PREHISTORICA.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[2 % $sedeCount],
                'nombre' => 'Rueda Panorámica',
                'descripcion' => 'Una hermosa rueda panorámica con vistas espectaculares del parque. Accesible para todas las edades.',
                'tipo' => 'Familiar',
                'capacidad' => 60,
                'altura_minima' => 0,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1c/18/eb/e7/noria.jpg?w=900&h=500&s=1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[3 % $sedeCount],
                'nombre' => 'Casa del Terror Amazónico',
                'descripcion' => 'Una experiencia de horror interactiva con efectos especiales y actores. Adecuada para mayores de 13 años.',
                'tipo' => 'Interactiva/Tecnologica',
                'capacidad' => 30,
                'altura_minima' => 130,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://live.staticflickr.com/5523/10279285785_0488aeb083_b.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[4 % $sedeCount],
                'nombre' => 'Splash Caribeño',
                'descripcion' => 'Un emocionante paseo acuático con salpicadas y caídas. Lleva traje de baño.',
                'tipo' => 'Familiar',
                'capacidad' => 40,
                'altura_minima' => 110,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://ccsuroccidente.parquesencolombia.com/assets/images/parque-norte-imagen-4-500x500.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[5 % $sedeCount],
                'nombre' => 'Tren de los Volcanes',
                'descripcion' => 'Un viaje en tren a través de un paisaje volcánico fantástico con efectos especiales.',
                'tipo' => 'Infantil',
                'capacidad' => 80,
                'altura_minima' => 90,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://upload.wikimedia.org/wikipedia/commons/8/83/Tar%C3%A1ntula_-_Parque_de_Atracciones_de_Madrid.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[6 % $sedeCount],
                'nombre' => 'Torre del Vértigo',
                'descripcion' => 'Una emocionante caída libre desde una altura de 50 metros. Altamente emocionante.',
                'tipo' => 'Extrema',
                'capacidad' => 16,
                'altura_minima' => 145,
                'estado_operativo' => 'Mantenimiento',
                'imagen_url' => 'https://thumbs.dreamstime.com/b/diversi%C3%B3n-del-parque-de-atracciones-muchachas-que-se-divierten-torre-que-cae-71795227.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[7 % $sedeCount],
                'nombre' => 'Safari Jurásico',
                'descripcion' => 'Un viaje interactivo donde verás dinosaurios de realidad aumentada. Experiencia educativa y divertida.',
                'tipo' => 'Interactiva/Tecnologica',
                'capacidad' => 45,
                'altura_minima' => 110,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/01/b3/f7/32/parque-jaime-duque-jardin.jpg?w=900&h=500&s=1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[8 % $sedeCount],
                'nombre' => 'Ciclón del Pacífico',
                'descripcion' => 'Un emocionante carrusel giratorio que aumenta la velocidad progresivamente. Para los valientes.',
                'tipo' => 'Extrema',
                'capacidad' => 36,
                'altura_minima' => 135,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://i.ytimg.com/vi/gepE91MVcLQ/maxresdefault.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'sede_id' => $sedes[9 % $sedeCount],
                'nombre' => 'Vuelo del Cóndor',
                'descripcion' => 'Un simulador de vuelo que te lleva a través de paisajes montañosos. Experiencia inmersiva.',
                'tipo' => 'Interactiva/Tecnologica',
                'capacidad' => 32,
                'altura_minima' => 125,
                'estado_operativo' => 'Operacional',
                'imagen_url' => 'https://c.pxhere.com/photos/b0/45/fair_carousel_folk_festival_chain_carousel_ride_speed_high_adrenaline-987290.jpg!s2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('atraccion')->insert($atracciones);
    }
}
