<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Use raw ALTERs to avoid case-insensitivity issues in MySQL
        if (Schema::hasTable('zona')) {
            if (Schema::hasColumn('zona', 'Nombre')) {
                DB::statement('ALTER TABLE `zona` CHANGE `Nombre` `nombre` VARCHAR(100) NOT NULL');
            }
            if (Schema::hasColumn('zona', 'Ubicacion')) {
                DB::statement('ALTER TABLE `zona` CHANGE `Ubicacion` `ubicacion` VARCHAR(100) NOT NULL');
            }
        }

        if (Schema::hasTable('tipo_ticket')) {
            if (Schema::hasColumn('tipo_ticket', 'Nombre')) {
                DB::statement('ALTER TABLE `tipo_ticket` CHANGE `Nombre` `nombre` VARCHAR(100) NOT NULL');
            }
            if (Schema::hasColumn('tipo_ticket', 'Validez_dias')) {
                DB::statement('ALTER TABLE `tipo_ticket` CHANGE `Validez_dias` `validez_dias` INT NOT NULL');
            }
            if (Schema::hasColumn('tipo_ticket', 'Descripción')) {
                DB::statement('ALTER TABLE `tipo_ticket` CHANGE `Descripción` `descripcion` VARCHAR(100) NOT NULL');
            }
            if (!Schema::hasColumn('tipo_ticket', 'reingresos')) {
                Schema::table('tipo_ticket', function (Blueprint $table) {
                    $table->boolean('reingresos')->default(false);
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('zona')) {
            if (Schema::hasColumn('zona', 'nombre')) {
                DB::statement('ALTER TABLE `zona` CHANGE `nombre` `Nombre` VARCHAR(100) NOT NULL');
            }
            if (Schema::hasColumn('zona', 'ubicacion')) {
                DB::statement('ALTER TABLE `zona` CHANGE `ubicacion` `Ubicacion` VARCHAR(100) NOT NULL');
            }
        }

        if (Schema::hasTable('tipo_ticket')) {
            if (Schema::hasColumn('tipo_ticket', 'nombre')) {
                DB::statement('ALTER TABLE `tipo_ticket` CHANGE `nombre` `Nombre` VARCHAR(100) NOT NULL');
            }
            if (Schema::hasColumn('tipo_ticket', 'validez_dias')) {
                DB::statement('ALTER TABLE `tipo_ticket` CHANGE `validez_dias` `Validez_dias` INT NOT NULL');
            }
            if (Schema::hasColumn('tipo_ticket', 'descripcion')) {
                DB::statement('ALTER TABLE `tipo_ticket` CHANGE `descripcion` `Descripción` VARCHAR(100) NOT NULL');
            }
            // keep reingresos as-is
        }
    }
};
