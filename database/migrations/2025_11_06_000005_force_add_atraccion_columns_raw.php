<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Force add columns using raw SQL; ignore if they already exist
        try {
            DB::statement('ALTER TABLE `atraccion` ADD COLUMN `nombre` VARCHAR(100) NULL');
        } catch (\Throwable $e) {
        }
        try {
            DB::statement('ALTER TABLE `atraccion` ADD COLUMN `capacidad` INT NULL');
        } catch (\Throwable $e) {
        }
        try {
            DB::statement('ALTER TABLE `atraccion` ADD COLUMN `estado_operativo` VARCHAR(100) NULL');
        } catch (\Throwable $e) {
        }
        try {
            DB::statement('ALTER TABLE `atraccion` ADD COLUMN `ubicacion_gps` VARCHAR(100) NULL');
        } catch (\Throwable $e) {
        }
    }

    public function down(): void
    {
        // no-op
    }
};
