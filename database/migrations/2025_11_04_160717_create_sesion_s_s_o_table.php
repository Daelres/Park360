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
        Schema::create('sesion_s_s_o', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios');
            $table->string('proveedor', 50);
            $table->string('oidc_sub', 191);
            $table->dateTime('exp_at');
            $table->string('refresh_token', 191)->nullable();
            $table->timestamps();
            $table->index(['usuario_id', 'proveedor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesion_s_s_o');
    }
};
