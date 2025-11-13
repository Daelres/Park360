<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('atraccion', function (Blueprint $table) {
            if (Schema::hasColumn('atraccion', 'Nombre') && !Schema::hasColumn('atraccion', 'nombre')) {
                $table->string('nombre', 100)->after('zona_id');
            }
            if (Schema::hasColumn('atraccion', 'Capacidad') && !Schema::hasColumn('atraccion', 'capacidad')) {
                $table->integer('capacidad')->after('nombre');
            }
            if (Schema::hasColumn('atraccion', 'Estado Operativo') && !Schema::hasColumn('atraccion', 'estado_operativo')) {
                $table->string('estado_operativo', 100)->after('capacidad');
            }
            if (Schema::hasColumn('atraccion', 'Ubicación_gps') && !Schema::hasColumn('atraccion', 'ubicacion_gps')) {
                $table->string('ubicacion_gps', 100)->after('estado_operativo');
            }
        });

        if (Schema::hasColumn('atraccion', 'Nombre')) {
            DB::statement('UPDATE `atraccion` SET `nombre` = `Nombre`');
        }
        if (Schema::hasColumn('atraccion', 'Capacidad')) {
            DB::statement('UPDATE `atraccion` SET `capacidad` = `Capacidad`');
        }
        if (Schema::hasColumn('atraccion', 'Estado Operativo')) {
            DB::statement('UPDATE `atraccion` SET `estado_operativo` = `Estado Operativo`');
        }
        if (Schema::hasColumn('atraccion', 'Ubicación_gps')) {
            DB::statement('UPDATE `atraccion` SET `ubicacion_gps` = `Ubicación_gps`');
        }

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
        Schema::table('atraccion', function (Blueprint $table) {
            if (!Schema::hasColumn('atraccion', 'Nombre') && Schema::hasColumn('atraccion', 'nombre')) {
                $table->string('Nombre', 100)->after('zona_id');
            }
            if (!Schema::hasColumn('atraccion', 'Capacidad') && Schema::hasColumn('atraccion', 'capacidad')) {
                $table->integer('Capacidad')->after('Nombre');
            }
            if (!Schema::hasColumn('atraccion', 'Estado Operativo') && Schema::hasColumn('atraccion', 'estado_operativo')) {
                $table->string('Estado Operativo', 100)->after('Capacidad');
            }
            if (!Schema::hasColumn('atraccion', 'Ubicación_gps') && Schema::hasColumn('atraccion', 'ubicacion_gps')) {
                $table->string('Ubicación_gps', 100)->after('Estado Operativo');
            }
        });

        if (Schema::hasColumn('atraccion', 'nombre')) {
            DB::statement('UPDATE `atraccion` SET `Nombre` = `nombre`');
        }
        if (Schema::hasColumn('atraccion', 'capacidad')) {
            DB::statement('UPDATE `atraccion` SET `Capacidad` = `capacidad`');
        }
        if (Schema::hasColumn('atraccion', 'estado_operativo')) {
            DB::statement('UPDATE `atraccion` SET `Estado Operativo` = `estado_operativo`');
        }
        if (Schema::hasColumn('atraccion', 'ubicacion_gps')) {
            DB::statement('UPDATE `atraccion` SET `Ubicación_gps` = `ubicacion_gps`');
        }

        Schema::table('atraccion', function (Blueprint $table) {
            if (Schema::hasColumn('atraccion', 'nombre')) {
                $table->dropColumn('nombre');
            }
            if (Schema::hasColumn('atraccion', 'capacidad')) {
                $table->dropColumn('capacidad');
            }
            if (Schema::hasColumn('atraccion', 'estado_operativo')) {
                $table->dropColumn('estado_operativo');
            }
            if (Schema::hasColumn('atraccion', 'ubicacion_gps')) {
                $table->dropColumn('ubicacion_gps');
            }
        });
    }
};
