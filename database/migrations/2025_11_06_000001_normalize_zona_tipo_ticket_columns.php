<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        $this->renameColumnPortable('zona', 'Nombre', 'nombre', function (Blueprint $table) {
            $table->string('nombre', 100)->nullable();
        });

        $this->renameColumnPortable('zona', 'Ubicacion', 'ubicacion', function (Blueprint $table) {
            $table->string('ubicacion', 100)->nullable();
        });

        $this->renameColumnPortable('tipo_ticket', 'Nombre', 'nombre', function (Blueprint $table) {
            $table->string('nombre', 100)->nullable();
        });

        $this->renameColumnPortable('tipo_ticket', 'Validez_dias', 'validez_dias', function (Blueprint $table) {
            $table->integer('validez_dias')->nullable();
        });

        $this->renameColumnPortable('tipo_ticket', 'Descripción', 'descripcion', function (Blueprint $table) {
            $table->string('descripcion', 100)->nullable();
        });

        if (Schema::hasTable('tipo_ticket') && ! $this->columnExists('tipo_ticket', 'reingresos')) {
            Schema::table('tipo_ticket', function (Blueprint $table) {
                $table->boolean('reingresos')->default(false);
            });
        }
    }

    public function down(): void
    {
        $this->renameColumnPortable('zona', 'nombre', 'Nombre', function (Blueprint $table) {
            $table->string('Nombre', 100)->nullable();
        });

        $this->renameColumnPortable('zona', 'ubicacion', 'Ubicacion', function (Blueprint $table) {
            $table->string('Ubicacion', 100)->nullable();
        });

        $this->renameColumnPortable('tipo_ticket', 'nombre', 'Nombre', function (Blueprint $table) {
            $table->string('Nombre', 100)->nullable();
        });

        $this->renameColumnPortable('tipo_ticket', 'validez_dias', 'Validez_dias', function (Blueprint $table) {
            $table->integer('Validez_dias')->nullable();
        });

        $this->renameColumnPortable('tipo_ticket', 'descripcion', 'Descripción', function (Blueprint $table) {
            $table->string('Descripción', 100)->nullable();
        });
        // keep reingresos as-is
    }

    private function renameColumnPortable(string $table, string $from, string $to, \Closure $definition, string $primaryKey = 'id'): void
    {
        if (! Schema::hasTable($table) || ! $this->columnExists($table, $from)) {
            return;
        }

        if ($this->columnExists($table, $to)) {
            $this->copyColumnData($table, $from, $to, $primaryKey);
            $this->dropColumnIfExists($table, $from);
            return;
        }

        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            $this->renameColumnUsingStatement($table, $from, $to, '"');
            return;
        }

        if ($driver === 'mysql') {
            $this->renameColumnUsingStatement($table, $from, $to, '`');
            return;
        }

        try {
            Schema::table($table, function (Blueprint $table) use ($from, $to) {
                $table->renameColumn($from, $to);
            });
        } catch (\Throwable $e) {
            // Give up quietly if the platform cannot rename this column.
        }
    }

    private function dropColumnIfExists(string $table, string $column): void
    {
        if (! $this->columnExists($table, $column)) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($column) {
            $table->dropColumn($column);
        });
    }

    private function copyColumnData(string $table, string $from, string $to, string $primaryKey): void
    {
        if (! $this->columnExists($table, $from) || ! $this->columnExists($table, $to)) {
            return;
        }

        $alias = 'source_column';
        $grammar = DB::connection()->getQueryGrammar();

        DB::table($table)
            ->select([
                $primaryKey,
                DB::raw($grammar->wrap($from).' as '.$alias),
            ])
            ->orderBy($primaryKey)
            ->chunkById(100, function ($rows) use ($table, $primaryKey, $to, $alias) {
                foreach ($rows as $row) {
                    DB::table($table)
                        ->where($primaryKey, $row->{$primaryKey})
                        ->update([$to => $row->{$alias}]);
                }
            }, $primaryKey);
    }

    private function columnExists(string $table, string $column, bool $caseInsensitive = false): bool
    {
        if (! Schema::hasTable($table)) {
            return false;
        }

        $columns = Schema::getColumnListing($table);

        if (! $caseInsensitive) {
            return in_array($column, $columns, true);
        }

        $target = strtolower($column);

        foreach ($columns as $existing) {
            if (strtolower($existing) === $target) {
                return true;
            }
        }

        return false;
    }

    private function renameColumnUsingStatement(string $table, string $from, string $to, string $quote): void
    {
        if (! $this->columnExists($table, $from) || $this->columnExists($table, $to)) {
            return;
        }

        $quotedTable = $this->wrapIdentifier($table, $quote);
        $quotedFrom = $this->wrapIdentifier($from, $quote);
        $quotedTo = $this->wrapIdentifier($to, $quote);

        try {
            DB::statement(sprintf('ALTER TABLE %s RENAME COLUMN %s TO %s', $quotedTable, $quotedFrom, $quotedTo));
        } catch (\Throwable $e) {
            // If the platform rejects the statement we silently leave the column untouched.
        }
    }

    private function wrapIdentifier(string $identifier, string $quote): string
    {
        $escaped = str_replace($quote, $quote.$quote, $identifier);

        return $quote.$escaped.$quote;
    }
};
