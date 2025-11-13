<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdenItemSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // Obtener órdenes creadas (IDs)
        $ordenes = DB::table('orden')->pluck('id')->toArray();

        // Obtener tipos de ticket disponibles (IDs)
        $tipos = DB::table('tipo_ticket')->pluck('id')->toArray();

        if (empty($ordenes) || empty($tipos)) {
            dd("⚠ No hay órdenes o tipos de ticket para generar orden_item.");
        }

        $items = [];

        foreach ($ordenes as $ordenId) {

            // Cada orden tendrá entre 1 y 4 ítems
            $cantidadItems = rand(1, 4);

            for ($i = 0; $i < $cantidadItems; $i++) {

                $tipoId = $tipos[array_rand($tipos)];

                // Precios simulados para distintos tipos de ticket
                $precio = rand(20000, 80000);
                $impuesto = intval($precio * 0.19);
                $descuento = rand(0, 1) ? 0 : rand(1000, 8000); // a veces tiene descuento

                $items[] = [
                    'orden_id' => $ordenId,
                    'tipo_ticket_id' => $tipoId,
                    'cantidad' => rand(1, 5),
                    'precio_unitario' => $precio,
                    'impuestos' => $impuesto,
                    'descuento' => $descuento,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('orden_item')->insert($items);
    }
}
