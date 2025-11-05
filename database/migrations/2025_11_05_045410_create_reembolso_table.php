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
        Schema::create('reembolso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_id')->constrained('pago');
            $table->decimal('monto',8,2);
            $table->string('motivo');
            $table->string('estado');
            $table->date('requested_at');
            $table->date('confirmed_at');
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
