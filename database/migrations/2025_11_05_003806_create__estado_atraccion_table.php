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
        Schema::create('estado_atraccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('atraccion_id')->constrained('atraccion');
            $table->string('estado', 30);
            $table->dateTime('desde');
            $table->dateTime('hasta')->nullable();
            $table->string('motivo', 255)->nullable();
            $table->foreignId('registrado_por_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_atraccion');
    }
};
