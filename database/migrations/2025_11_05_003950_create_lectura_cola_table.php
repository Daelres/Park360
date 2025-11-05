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
            $table->integer('personas_en_cola');
            $table->integer('tiempos_de_espera');
            $table->string('fuente');
            $table->timestamps();
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
