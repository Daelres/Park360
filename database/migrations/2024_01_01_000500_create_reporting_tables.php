<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attraction_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attraction_id')->constrained('attractions')->cascadeOnDelete();
            $table->date('date');
            $table->unsignedInteger('visitors_count')->default(0);
            $table->unsignedInteger('incidents_count')->default(0);
            $table->unsignedInteger('maintenance_count')->default(0);
            $table->decimal('satisfaction_score', 5, 2)->nullable();
            $table->timestamps();
            $table->unique(['attraction_id', 'date']);
        });

        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('recipient');
            $table->string('channel');
            $table->json('payload');
            $table->enum('status', ['queued', 'sent', 'failed'])->default('queued');
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('system_backups', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('type');
            $table->unsignedBigInteger('size');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('verified_at')->nullable();
        });

        Schema::create('system_metrics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('value', 12, 4);
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_metrics');
        Schema::dropIfExists('system_backups');
        Schema::dropIfExists('notification_logs');
        Schema::dropIfExists('attraction_metrics');
    }
};
