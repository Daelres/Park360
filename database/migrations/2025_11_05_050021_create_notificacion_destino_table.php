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
        Schema::create('notificacion_destino', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notificacion_id')->constrained('notificacion');
            $table->string('destinatario_email');
            $table->string('estado_envio');
            $table->string('proveedor_msg_id');
            $table->date('sent_at');
            $table->integer('retry_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificacion_destino');
    }
};
