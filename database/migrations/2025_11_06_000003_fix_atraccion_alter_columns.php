<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        // All column normalization is handled in previous migrations. This
        // placeholder remains to keep the history but intentionally performs
        // no work so deployments on SQLite avoid unsupported ALTER TABLE SQL.
    }

    public function down(): void
    {
        // No-op
    }
};
