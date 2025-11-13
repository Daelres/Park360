<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('atraccion', function (Blueprint $table) {
            // Make ubicacion_gps nullable - try both possible column names
            if (Schema::hasColumn('atraccion', 'ubicacion_gps')) {
                $table->string('ubicacion_gps')->nullable()->change();
            }
            if (Schema::hasColumn('atraccion', 'Ubicación_gps')) {
                $table->string('Ubicación_gps')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atraccion', function (Blueprint $table) {
            if (Schema::hasColumn('atraccion', 'ubicacion_gps')) {
                $table->string('ubicacion_gps')->nullable(false)->change();
            }
            if (Schema::hasColumn('atraccion', 'Ubicación_gps')) {
                $table->string('Ubicación_gps')->nullable(false)->change();
            }
        });
    }
};
