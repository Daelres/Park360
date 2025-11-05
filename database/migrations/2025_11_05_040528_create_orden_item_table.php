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
        Schema::create('orden_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orden');
            $table->foreignId('tipo_ticket_id')->constrained('tipo_ticket');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 8, 2);
            $table->decimal('impuestos', 8, 2);
            $table->decimal('descuento', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_item');
    }
};
