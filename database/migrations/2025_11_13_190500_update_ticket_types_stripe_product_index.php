<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('ticket_types')) {
            return;
        }

        // Only try to drop the unique constraint if it exists
        $indexExists = DB::select(
            "SELECT CONSTRAINT_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME='ticket_types' AND COLUMN_NAME='stripe_product_id' AND CONSTRAINT_NAME='ticket_types_stripe_product_id_unique'"
        );

        if (!empty($indexExists)) {
            Schema::table('ticket_types', function (Blueprint $table) {
                $table->dropUnique('ticket_types_stripe_product_id_unique');
            });
        }

        // Add index if it doesn't already exist
        try {
            Schema::table('ticket_types', function (Blueprint $table) {
                $table->index('stripe_product_id', 'ticket_types_stripe_product_id_index');
            });
        } catch (\Throwable $exception) {
            // Index might already exist; ignore
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('ticket_types')) {
            return;
        }

        Schema::table('ticket_types', function (Blueprint $table) {
            try {
                $table->dropIndex('ticket_types_stripe_product_id_index');
            } catch (\Throwable $exception) {
                // Index might be absent; ignore
            }

            try {
                $table->unique('stripe_product_id', 'ticket_types_stripe_product_id_unique');
            } catch (\Throwable $exception) {
                // Unique constraint may already exist; ignore
            }
        });
    }
};
