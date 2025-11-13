<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('ticket_orders')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            Schema::table('ticket_orders', function ($table) {
                $table->text('stripe_client_secret')->nullable()->change();
            });
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE ticket_orders ALTER COLUMN stripe_client_secret TYPE TEXT');
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('ticket_orders')) {
            return;
        }

        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            Schema::table('ticket_orders', function ($table) {
                $table->string('stripe_client_secret', 255)->nullable()->change();
            });
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE ticket_orders ALTER COLUMN stripe_client_secret TYPE VARCHAR(255)');
        }
    }
};
