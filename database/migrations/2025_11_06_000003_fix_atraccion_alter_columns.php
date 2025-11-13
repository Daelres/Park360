<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('atraccion')) {
            // Use raw ALTER to rename problematic columns reliably
            try {
                DB::statement('ALTER TABLE `atraccion` CHANGE `Nombre` `nombre` VARCHAR(100) NOT NULL');
            } catch (\Throwable $e) {
            }
            try {
                DB::statement('ALTER TABLE `atraccion` CHANGE `Capacidad` `capacidad` INT NOT NULL');
            } catch (\Throwable $e) {
            }
            try {
                DB::statement('ALTER TABLE `atraccion` CHANGE `Estado Operativo` `estado_operativo` VARCHAR(100) NOT NULL');
            } catch (\Throwable $e) {
            }
            try {
                DB::statement('ALTER TABLE `atraccion` CHANGE `Ubicación_gps` `ubicacion_gps` VARCHAR(100) NOT NULL');
            } catch (\Throwable $e) {
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('atraccion')) {
            try {
                DB::statement('ALTER TABLE `atraccion` CHANGE `nombre` `Nombre` VARCHAR(100) NOT NULL');
            } catch (\Throwable $e) {
            }
            try {
                DB::statement('ALTER TABLE `atraccion` CHANGE `capacidad` `Capacidad` INT NOT NULL');
            } catch (\Throwable $e) {
            }
            try {
                DB::statement('ALTER TABLE `atraccion` CHANGE `estado_operativo` `Estado Operativo` VARCHAR(100) NOT NULL');
            } catch (\Throwable $e) {
            }
            try {
                DB::statement('ALTER TABLE `atraccion` CHANGE `ubicacion_gps` `Ubicación_gps` VARCHAR(100) NOT NULL');
            } catch (\Throwable $e) {
            }
        }
    }
};
