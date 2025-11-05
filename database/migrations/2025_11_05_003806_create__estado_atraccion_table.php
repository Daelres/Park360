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
        Schema::create('_estado_atraccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atraccion_id')->constrained('atraccion');
            $table->string('estado');
            $table->date('desde');
            $table->date('hasta');
            $table->string('motivo');
            $table->foreignId('registrado_por')->constrained('usuarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_estado_atraccion');
    }
};
