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
        Schema::create('tarifa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_ticket_id')->constrained('tipo_ticket');
            $table->decimal('precio', 8, 2);
            $table->string('moneda');
            $table->date('vigncia_desde');
            $table->date('vigncia_hasta');
            $table->string('canal_venta');
            $table->jsonb('regla');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifa');
    }
};
