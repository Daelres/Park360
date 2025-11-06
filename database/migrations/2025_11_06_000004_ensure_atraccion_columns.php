<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atraccion', function (Blueprint $table) {
            if (!Schema::hasColumn('atraccion', 'nombre')) {
                $table->string('nombre', 100)->after('zona_id');
            }
            if (!Schema::hasColumn('atraccion', 'capacidad')) {
                $table->integer('capacidad')->after('nombre');
            }
            if (!Schema::hasColumn('atraccion', 'estado_operativo')) {
                $table->string('estado_operativo', 100)->after('capacidad');
            }
            if (!Schema::hasColumn('atraccion', 'ubicacion_gps')) {
                $table->string('ubicacion_gps', 100)->after('estado_operativo');
            }
        });

        // Try to copy data from legacy columns when present
        try { DB::statement('UPDATE `atraccion` SET `nombre` = `Nombre` WHERE `nombre` IS NULL OR `nombre` = ""'); } catch (\Throwable $e) {}
        try { DB::statement('UPDATE `atraccion` SET `capacidad` = `Capacidad` WHERE `capacidad` IS NULL'); } catch (\Throwable $e) {}
        try { DB::statement('UPDATE `atraccion` SET `estado_operativo` = `Estado Operativo` WHERE `estado_operativo` IS NULL OR `estado_operativo` = ""'); } catch (\Throwable $e) {}
        try { DB::statement('UPDATE `atraccion` SET `ubicacion_gps` = `Ubicación_gps` WHERE `ubicacion_gps` IS NULL OR `ubicacion_gps` = ""'); } catch (\Throwable $e) {}

        // Drop legacy columns if still present
        Schema::table('atraccion', function (Blueprint $table) {
            if (Schema::hasColumn('atraccion', 'Nombre')) {
                $table->dropColumn('Nombre');
            }
            if (Schema::hasColumn('atraccion', 'Capacidad')) {
                $table->dropColumn('Capacidad');
            }
            if (Schema::hasColumn('atraccion', 'Estado Operativo')) {
                $table->dropColumn('Estado Operativo');
            }
            if (Schema::hasColumn('atraccion', 'Ubicación_gps')) {
                $table->dropColumn('Ubicación_gps');
            }
        });
    }

    public function down(): void
    {
        // No-op safe down
    }
};
