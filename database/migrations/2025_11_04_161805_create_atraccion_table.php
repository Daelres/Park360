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
        Schema::create('atraccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('zona_id')->constrained('zona');
            $table->string('Nombre', 100);
            $table->integer('Capacidad');
            $table->string('Estado Operativo', 100);
            $table->string('Ubicación_gps', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('atraccion');
    }
};
