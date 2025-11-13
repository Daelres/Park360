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
        Schema::create('tarea_operativa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('atractivo_id');
            $table->foreignId('asignada_a')->constrained('users');
            $table->string('titulo');
            $table->string('prioridad');
            $table->string('estado');
            $table->integer('sla_horas');
            $table->string('origen');
            $table->date('vencimiento_at');
            $table->timestamps();
        });

        if (Schema::hasTable('atraccion')) {
            Schema::table('tarea_operativa', function (Blueprint $table) {
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
        if (Schema::hasTable('tarea_operativa')) {
            try {
                Schema::table('tarea_operativa', function (Blueprint $table) {
                    if (Schema::hasColumn('tarea_operativa', 'atractivo_id')) {
                        $table->dropForeign(['atractivo_id']);
                    }

                    if (Schema::hasColumn('tarea_operativa', 'asignada_a')) {
                        $table->dropForeign(['asignada_a']);
                    }
                });
            } catch (\Throwable $e) {
                // Ignore missing constraints on databases without FK support.
            }
        }

        Schema::dropIfExists('tarea_operativa');
    }
};
