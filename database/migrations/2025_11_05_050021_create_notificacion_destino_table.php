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
        Schema::create('notificacion_destino', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notificacion_id')->constrained('notificacion');
            $table->string('destinatario_email', 191);
            $table->string('estado_envio', 30)->default('pendiente');
            $table->string('proveedor_msg_id', 191)->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->unsignedTinyInteger('retry_count')->default(0);
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
