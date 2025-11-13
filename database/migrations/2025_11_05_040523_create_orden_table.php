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
        Schema::create('orden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('cliente');
            $table->string('numero_orden', 50)->unique();
            $table->string('estado', 30);
            $table->decimal('total', 10, 2);
            $table->string('canal', 50)->nullable();
            $table->string('ip_cliente', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden');
    }
};
