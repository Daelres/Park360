<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('atraccion')) {
            return;
        }

        Schema::table('atraccion', function (Blueprint $table) {
            if (! Schema::hasColumn('atraccion', 'nombre')) {
                $table->string('nombre', 100)->nullable();
            }
            if (! Schema::hasColumn('atraccion', 'capacidad')) {
                $table->integer('capacidad')->nullable();
            }
            if (! Schema::hasColumn('atraccion', 'estado_operativo')) {
                $table->string('estado_operativo', 100)->nullable();
            }
            if (! Schema::hasColumn('atraccion', 'ubicacion_gps')) {
                $table->string('ubicacion_gps', 100)->nullable();
            }
        });
    }

    public function down(): void
    {
        // No-op safe down
    }
};
