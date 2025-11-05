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
        Schema::create('incidente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atraccion_id')->constrained('atraccion');
            $table->foreignId('reportado_por')->constrained('usuarios');
            $table->string('tipo');
            $table->string('severidad');
            $table->string('descripcion');
            $table->date('inicio_at');
            $table->date('fin_at');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidente');
    }
};
