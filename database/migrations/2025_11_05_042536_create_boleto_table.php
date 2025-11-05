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
        Schema::create('boleto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('orden');
            $table->foreignId('tipo_ticket_id')->constrained('tipo_ticket');
            $table->string('qr_code');
            $table->string('estado');
            $table->date('valido_desde');
            $table->date('valido_hasta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boleto');
    }
};
