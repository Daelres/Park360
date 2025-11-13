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
            // Make zona_id nullable
            if (Schema::hasColumn('atraccion', 'zona_id')) {
                $table->foreignId('zona_id')->nullable()->change();
            }
            // Drop ubicacion_gps column
            if (Schema::hasColumn('atraccion', 'Ubicación_gps')) {
                $table->dropColumn('Ubicación_gps');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('atraccion', function (Blueprint $table) {
            if (Schema::hasColumn('atraccion', 'zona_id')) {
                $table->foreignId('zona_id')->nullable(false)->change();
            }
            if (!Schema::hasColumn('atraccion', 'Ubicación_gps')) {
                $table->string('Ubicación_gps', 100)->nullable();
            }
        });
    }
};
