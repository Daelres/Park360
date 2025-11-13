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
        Schema::create('mantenimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atractivo_id');
            $table->string('tipo');
            $table->date('inicio_programado');
            $table->date('fin_programado');
            $table->date('inicio_real');
            $table->date('fin_real');
            $table->foreignId('responsable')->constrained('users');
            $table->string('estado');
            $table->timestamps();
        });

        if (Schema::hasTable('atraccion')) {
            Schema::table('mantenimiento', function (Blueprint $table) {
                $table->foreign('atractivo_id')
                    ->references('id')
                    ->on('atraccion')
                    ->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('mantenimiento')) {
            try {
                Schema::table('mantenimiento', function (Blueprint $table) {
                    if (Schema::hasColumn('mantenimiento', 'atractivo_id')) {
                        $table->dropForeign(['atractivo_id']);
                    }

                    if (Schema::hasColumn('mantenimiento', 'responsable')) {
                        $table->dropForeign(['responsable']);
                    }
                });
            } catch (\Throwable $e) {
                // Ignore if the foreign key was not created on this platform.
            }
        }

        Schema::dropIfExists('mantenimiento');
    }
};
