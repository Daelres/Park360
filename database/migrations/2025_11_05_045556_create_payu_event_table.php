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
        Schema::create('payu_event', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('orden');
            $table->foreignId('pago_id')->constrained('pago');
            $table->json('payload');
            $table->string('event_type', 50);
            $table->dateTime('received_at');
            $table->boolean('firma_valida')->default(false);
            $table->string('replay_id', 100)->nullable();
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
