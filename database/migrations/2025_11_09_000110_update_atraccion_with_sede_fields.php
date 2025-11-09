<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('atraccion', function (Blueprint $table) {
            if (!Schema::hasColumn('atraccion', 'sede_id')) {
                $table->foreignId('sede_id')->nullable()->after('zona_id')->constrained('sedes');
            }
            if (!Schema::hasColumn('atraccion', 'descripcion')) {
                $table->text('descripcion')->nullable()->after('nombre');
            }
            if (!Schema::hasColumn('atraccion', 'tipo')) {
                $table->string('tipo')->nullable()->after('descripcion');
            }
            if (!Schema::hasColumn('atraccion', 'altura_minima')) {
                $table->unsignedInteger('altura_minima')->nullable()->after('tipo');
            }
            if (!Schema::hasColumn('atraccion', 'imagen_url')) {
                $table->string('imagen_url')->nullable()->after('ubicacion_gps');
            }
        });
    }

    public function down(): void
    {
        Schema::table('atraccion', function (Blueprint $table) {
            if (Schema::hasColumn('atraccion', 'imagen_url')) {
                $table->dropColumn('imagen_url');
            }
            if (Schema::hasColumn('atraccion', 'altura_minima')) {
                $table->dropColumn('altura_minima');
            }
            if (Schema::hasColumn('atraccion', 'tipo')) {
                $table->dropColumn('tipo');
            }
            if (Schema::hasColumn('atraccion', 'descripcion')) {
                $table->dropColumn('descripcion');
            }
            if (Schema::hasColumn('atraccion', 'sede_id')) {
                $table->dropConstrainedForeignId('sede_id');
            }
        });
    }
};
