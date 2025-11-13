<?php

namespace Database\Seeders;

use App\Models\AddonProduct;
use App\Models\Sede;
use App\Models\TicketType;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TicketCatalogSeeder extends Seeder
{
    /**
     * Seed ticket types and add-on products sourced from Stripe catalog.
     */
    public function run(): void
    {
        $this->seedTicketTypes();
        $this->seedAddonProducts();
    }

    private function seedTicketTypes(): void
    {
        $tickets = [
            [
                'code' => 'GENERAL',
                'name' => 'Entrada General',
                'description' => 'Acceso ilimitado a todas las atracciones estándar. Shows en vivo generales. Uso de zonas comunes y áreas de descanso.',
                'base_price' => 100_000,
                'stripe_product_id' => 'prod_TPhyMZUxeAHALJ',
                'stripe_price_id' => null,
            ],
            [
                'code' => 'VIP',
                'name' => 'Entrada VIP',
                'description' => 'Todo lo de la entrada general. Acceso preferencial a atracciones, zona exclusiva y descuentos en el parque.',
                'base_price' => 150_000,
                'stripe_product_id' => 'prod_TPhzyG2pgmqHB2',
                'stripe_price_id' => null,
            ],
            [
                'code' => 'PRO',
                'name' => 'Entrada PRO',
                'description' => 'Incluye experiencia VIP más Fast Pass ilimitado, lounge premium con alimentos/bebidas, foto profesional y kit de bienvenida.',
                'base_price' => 250_000,
                'stripe_product_id' => 'prod_TPhzLx26wFL6ql',
                'stripe_price_id' => null,
            ],
        ];

        $sedes = Sede::orderBy('id')->get();

        if ($sedes->isEmpty()) {
            return;
        }

        foreach ($sedes as $index => $sede) {
            foreach ($tickets as $ticket) {
                // Use the same Stripe product ID for all sedes
                // Each sede will have different prices, but same product
                $productId = $ticket['stripe_product_id']
                    ?: sprintf('prod_%s_base', $ticket['code']);

                TicketType::updateOrCreate(
                    ['sede_id' => $sede->id, 'code' => $ticket['code']],
                    [
                        'sede_id' => $sede->id,
                        'code' => $ticket['code'],
                        'name' => $ticket['name'],
                        'description' => $ticket['description'],
                        'base_price' => $ticket['base_price'],
                        'stripe_product_id' => $productId,
                        'stripe_price_id' => $ticket['stripe_price_id'],
                    ]
                );
            }
        }
    }

    private function seedAddonProducts(): void
    {
        $addons = [
            [
                'code' => 'FAST_PASS_GENERAL',
                'name' => 'Fast Pass General',
                'description' => 'Acceso rápido a atracciones para el pase General.',
                'price' => 60_000,
                'stripe_product_id' => 'prod_TPju4kw1LrPpNk',
                'stripe_price_id' => null,
            ],
            [
                'code' => 'FAST_PASS_VIP',
                'name' => 'Fast Pass VIP',
                'description' => 'Acceso rápido a atracciones para el pase VIP.',
                'price' => 80_000,
                'stripe_product_id' => 'prod_TPjukgsGBDQ3wj',
                'stripe_price_id' => null,
            ],
            [
                'code' => 'BONO_LLUVIA_GENERAL',
                'name' => 'Bono de Lluvia General',
                'description' => 'Garantiza un beneficio si llueve durante tu visita con pase General.',
                'price' => 10_000,
                'stripe_product_id' => 'prod_TPjwSCaT983WRD',
                'stripe_price_id' => null,
            ],
            [
                'code' => 'BONO_LLUVIA_VIP',
                'name' => 'Bono de Lluvia VIP',
                'description' => 'Protección por lluvia pensada para quienes adquieren experiencia VIP.',
                'price' => 12_000,
                'stripe_product_id' => 'prod_TPjw7TEsdydd9m',
                'stripe_price_id' => null,
            ],
            [
                'code' => 'PARQUEADERO_AUTOS',
                'name' => 'Parqueadero Autos',
                'description' => 'Espacio seguro en el parqueadero para automóviles.',
                'price' => 25_000,
                'stripe_product_id' => 'prod_TPk2HtoQVbG9tY',
                'stripe_price_id' => null,
            ],
            [
                'code' => 'PARQUEADERO_MOTOS',
                'name' => 'Parqueadero Motos/Bicicletas',
                'description' => 'Cupo de parqueadero para motos o bicicletas.',
                'price' => 5_000,
                'stripe_product_id' => 'prod_TPk3xwaDwyN9i9',
                'stripe_price_id' => null,
            ],
            [
                'code' => 'CARROS_CHOCONES',
                'name' => 'Carritos Chocones',
                'description' => 'Acceso a la atracción de carritos chocones.',
                'price' => 12_000,
                'stripe_product_id' => 'prod_TPk4pB89OJZICF',
                'stripe_price_id' => null,
            ],
            [
                'code' => 'PISTA_KARTS',
                'name' => 'Pista de Karts',
                'description' => 'Experiencia adicional en la pista de karts.',
                'price' => 18_000,
                'stripe_product_id' => 'prod_TPk4Garj41xJPo',
                'stripe_price_id' => null,
            ],
            [
                'code' => 'CASTILLO_3D',
                'name' => 'Castillo 3D',
                'description' => 'Atracción temática inmersiva estilo castillo 3D.',
                'price' => 15_000,
                'stripe_product_id' => 'prod_TPk4gw8MoStnnL',
                'stripe_price_id' => null,
            ],
        ];

        foreach ($addons as $addon) {
            AddonProduct::updateOrCreate(
                ['code' => $addon['code']],
                $addon
            );
        }
    }
}
