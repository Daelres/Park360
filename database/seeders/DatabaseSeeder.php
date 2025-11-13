<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Opcional: deshabilitar checks de FK en desarrollo para reseed limpio (MySQL)
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } catch (\Throwable $e) {
            // Ignorar si el motor no soporta este flag (p.ej. SQLite/Postgres)
        }

        $this->call([
            UsersSeeder::class,
            RolSeeder::class,
            PermisoSeeder::class,
            ZonaSeeder::class,
            SedesSeeder::class,  // Movido antes de AtraccionSeeder
            AtraccionSeeder::class,
            VisitDateSeeder::class,
            TicketCatalogSeeder::class,
            TipoTicketSeeder::class,
            EmpleadoSeeder::class,
            PermisoRolSeeder::class,
            UserRolSeeder::class,
            ClienteSeeder::class,
            OrdenSeeder::class,
            OrdenItemSeeder::class,
            BoletoSeeder::class,
            CheckInSeeder::class,
            NotificacionSeeder::class,
            NotificacionDestinoSeeder::class,
            PreferenciaNotificacionSeeder::class,
            SesionSSOSeeder::class,
            AsistenciaSeeder::class,
            CalendarioAtraccionSeeder::class,
            EstadoAtraccionSeeder::class,
            IncidenteSeeder::class,
            LecturaColaSeeder::class,
            MantenimientoSeeder::class,
            PagoSeeder::class,
            ReembolsoSeeder::class,
            TareaOperativaSeeder::class,
            TarifaSeeder::class,
            TurnoSeeder::class,

        ]);

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        } catch (\Throwable $e) {
        }
    }
}
