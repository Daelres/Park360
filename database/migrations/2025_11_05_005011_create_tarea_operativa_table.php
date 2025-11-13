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
        Schema::create('tarea_operativa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atractivo_id')->constrained('atraccion');
            $table->foreignId('asignada_a')->constrained('users');
            $table->string('titulo');
            $table->string('prioridad');
            $table->string('estado');
            $table->integer('sla_horas');
            $table->string('origen');
            $table->date('vencimiento_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarea_operativa');
    }
};
