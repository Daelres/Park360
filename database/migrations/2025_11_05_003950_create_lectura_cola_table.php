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
        Schema::create('lectura_cola', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atraccion_id')->constrained('atraccion');
            $table->unsignedSmallInteger('personas_en_cola')->default(0);
            $table->unsignedSmallInteger('tiempo_espera_min')->default(0);
            $table->string('fuente', 50)->nullable();
            $table->timestamps();
            $table->index(['atraccion_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectura_cola');
    }
};
