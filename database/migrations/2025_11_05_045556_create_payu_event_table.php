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
        Schema::create('payu_event', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('orden');
            $table->foreignId('pago_id')->constrained('pago');
            $table->jsonb('payload');
            $table->string('event_type');
            $table->date('recived_at');
            $table->boolean('firma_valida');
            $table->string('replay_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payu_event');
    }
};
