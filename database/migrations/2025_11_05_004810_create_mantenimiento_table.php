<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mantenimiento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atractivo_id')->constrained('atraccion');
            $table->string('tipo');
            $table->date('inicio_programado');
            $table->date('fin_programado');
            $table->date('inicio_real');
            $table->date('fin_real');
            $table->foreignId('responsable')->constrained('users');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento');
    }
};
