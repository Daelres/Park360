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
        Schema::create('reembolso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_id')->constrained('pago');
            $table->decimal('monto', 10, 2);
            $table->string('motivo', 255)->nullable();
            $table->string('estado', 30);
            $table->dateTime('requested_at');
            $table->dateTime('confirmed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reembolso');
    }
};
