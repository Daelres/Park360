<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('ticket_types')) {
            Schema::table('ticket_types', function (Blueprint $table) {
                if (! Schema::hasColumn('ticket_types', 'sede_id')) {
                    $table->foreignId('sede_id')
                        ->nullable()
                        ->after('id')
                        ->constrained('sedes')
                        ->cascadeOnDelete();
                }
            });

            if (Schema::hasColumn('ticket_types', 'code')) {
                try {
                    Schema::table('ticket_types', function (Blueprint $table) {
                        $table->dropUnique('ticket_types_code_unique');
                    });
                } catch (\Throwable $exception) {
                    // Ignore if unique constraint already absent
                }

                try {
                    Schema::table('ticket_types', function (Blueprint $table) {
                        $table->dropUnique('ticket_types_sede_code_unique');
                    });
                } catch (\Throwable $exception) {
                    // Ignore if composite constraint does not exist yet
                }

                Schema::table('ticket_types', function (Blueprint $table) {
                    $table->unique(['sede_id', 'code'], 'ticket_types_sede_code_unique');
                });
            }

            $defaultSedeId = DB::table('sedes')->value('id');

            if ($defaultSedeId) {
                DB::table('ticket_types')
                    ->whereNull('sede_id')
                    ->update(['sede_id' => $defaultSedeId]);
            }
        }

        if (Schema::hasTable('ticket_orders')) {
            Schema::table('ticket_orders', function (Blueprint $table) {
                if (! Schema::hasColumn('ticket_orders', 'sede_id')) {
                    $table->foreignId('sede_id')
                        ->nullable()
                        ->after('user_id')
                        ->constrained('sedes')
                        ->nullOnDelete();
                }
            });

            $defaultSedeId = DB::table('sedes')->value('id');

            if ($defaultSedeId) {
                DB::table('ticket_orders')
                    ->whereNull('sede_id')
                    ->update(['sede_id' => $defaultSedeId]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ticket_orders')) {
            Schema::table('ticket_orders', function (Blueprint $table) {
                if (Schema::hasColumn('ticket_orders', 'sede_id')) {
                    $table->dropConstrainedForeignId('sede_id');
                }
            });
        }

        if (Schema::hasTable('ticket_types')) {
            Schema::table('ticket_types', function (Blueprint $table) {
                try {
                    $table->dropUnique('ticket_types_sede_code_unique');
                } catch (\Throwable $exception) {
                    // ignore if unique constraint does not exist
                }

                if (Schema::hasColumn('ticket_types', 'sede_id')) {
                    $table->dropConstrainedForeignId('sede_id');
                }

                if (Schema::hasColumn('ticket_types', 'code')) {
                    $table->unique('code', 'ticket_types_code_unique');
                }
            });
        }
    }
};
