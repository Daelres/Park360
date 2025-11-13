<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('usuarios')) {
            $usuarios = DB::table('usuarios')->orderBy('id')->get();

            foreach ($usuarios as $usuario) {
                $existing = DB::table('users')->where('id', $usuario->id)->first();

                $payload = [
                    'name' => $usuario->nombre ?? $usuario->email,
                    'email' => $usuario->email,
                    'estado' => $usuario->estado ?? 'activo',
                    'ultimo_login' => $usuario->ultimo_login,
                    'updated_at' => $usuario->updated_at ?? now(),
                ];

                if ($existing) {
                    DB::table('users')->where('id', $usuario->id)->update($payload);
                } else {
                    DB::table('users')->insert([
                        'id' => $usuario->id,
                        'name' => $usuario->nombre ?? $usuario->email,
                        'email' => $usuario->email,
                        'password' => Hash::make(Str::random(32)),
                        'estado' => $usuario->estado ?? 'activo',
                        'ultimo_login' => $usuario->ultimo_login,
                        'email_verified_at' => null,
                        'remember_token' => Str::random(10),
                        'created_at' => $usuario->created_at ?? now(),
                        'updated_at' => $usuario->updated_at ?? now(),
                    ]);
                }
            }
        }

        Schema::disableForeignKeyConstraints();

        $this->migrateUserRolePivot();
        $this->migrateEmpleado();
        $this->migrateSesionSSO();
        $this->migratePreferenciaNotificacion();
        $this->migrateMantenimiento();
        $this->migrateTareaOperativa();
        $this->retargetEstadoAtraccion();
        $this->retargetIncidente();

        Schema::enableForeignKeyConstraints();

        if (Schema::hasTable('usuarios')) {
            Schema::drop('usuarios');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('email', 191)->unique();
            $table->string('nombre', 100);
            $table->string('estado', 30)->default('activo');
            $table->timestamp('ultimo_login')->nullable();
            $table->timestamps();
        });

        $users = DB::table('users')->orderBy('id')->get();
        foreach ($users as $user) {
            DB::table('usuarios')->insert([
                'id' => $user->id,
                'email' => $user->email,
                'nombre' => $user->name,
                'estado' => $user->estado ?? 'activo',
                'ultimo_login' => $user->ultimo_login,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ]);
        }

        Schema::disableForeignKeyConstraints();

        $this->rollbackIncidente();
        $this->rollbackEstadoAtraccion();
        $this->rollbackTareaOperativa();
        $this->rollbackMantenimiento();
        $this->rollbackPreferenciaNotificacion();
        $this->rollbackSesionSSO();
        $this->rollbackEmpleado();
        $this->rollbackUserRolePivot();

        Schema::enableForeignKeyConstraints();
    }

    private function migrateUserRolePivot(): void
    {
        if (! Schema::hasTable('user_rol') || ! Schema::hasColumn('user_rol', 'usuario_id')) {
            return;
        }

        Schema::table('user_rol', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            try {
                $table->dropUnique('user_rol_usuario_id_rol_id_unique');
            } catch (\Throwable $e) {
                // ignore if the constraint name does not exist
            }
        });

        Schema::table('user_rol', function (Blueprint $table) {
            $table->renameColumn('usuario_id', 'user_id');
        });

        Schema::table('user_rol', function (Blueprint $table) {
            $table->unique(['user_id', 'rol_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    private function rollbackUserRolePivot(): void
    {
        if (! Schema::hasTable('user_rol') || ! Schema::hasColumn('user_rol', 'user_id')) {
            return;
        }

        Schema::table('user_rol', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            try {
                $table->dropUnique('user_rol_user_id_rol_id_unique');
            } catch (\Throwable $e) {
            }
        });

        Schema::table('user_rol', function (Blueprint $table) {
            $table->renameColumn('user_id', 'usuario_id');
        });

        Schema::table('user_rol', function (Blueprint $table) {
            $table->unique(['usuario_id', 'rol_id']);
            $table->foreign('usuario_id')->references('id')->on('usuarios')->cascadeOnDelete();
        });
    }

    private function migrateEmpleado(): void
    {
        if (! Schema::hasTable('empleado') || ! Schema::hasColumn('empleado', 'usuario_id')) {
            return;
        }

        Schema::table('empleado', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
        });

        Schema::table('empleado', function (Blueprint $table) {
            $table->renameColumn('usuario_id', 'user_id');
        });

        Schema::table('empleado', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    private function rollbackEmpleado(): void
    {
        if (! Schema::hasTable('empleado') || ! Schema::hasColumn('empleado', 'user_id')) {
            return;
        }

        Schema::table('empleado', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('empleado', function (Blueprint $table) {
            $table->renameColumn('user_id', 'usuario_id');
        });

        Schema::table('empleado', function (Blueprint $table) {
            $table->foreign('usuario_id')->references('id')->on('usuarios')->cascadeOnDelete();
        });
    }

    private function migrateSesionSSO(): void
    {
        if (! Schema::hasTable('sesion_s_s_o') || ! Schema::hasColumn('sesion_s_s_o', 'usuario_id')) {
            return;
        }

        Schema::table('sesion_s_s_o', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            try {
                $table->dropIndex('sesion_s_s_o_usuario_id_proveedor_index');
            } catch (\Throwable $e) {
            }
        });

        Schema::table('sesion_s_s_o', function (Blueprint $table) {
            $table->renameColumn('usuario_id', 'user_id');
        });

        Schema::table('sesion_s_s_o', function (Blueprint $table) {
            $table->index(['user_id', 'proveedor']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    private function rollbackSesionSSO(): void
    {
        if (! Schema::hasTable('sesion_s_s_o') || ! Schema::hasColumn('sesion_s_s_o', 'user_id')) {
            return;
        }

        Schema::table('sesion_s_s_o', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            try {
                $table->dropIndex('sesion_s_s_o_user_id_proveedor_index');
            } catch (\Throwable $e) {
            }
        });

        Schema::table('sesion_s_s_o', function (Blueprint $table) {
            $table->renameColumn('user_id', 'usuario_id');
        });

        Schema::table('sesion_s_s_o', function (Blueprint $table) {
            $table->index(['usuario_id', 'proveedor']);
            $table->foreign('usuario_id')->references('id')->on('usuarios')->cascadeOnDelete();
        });
    }

    private function migratePreferenciaNotificacion(): void
    {
        if (! Schema::hasTable('preferencia_notificacion') || ! Schema::hasColumn('preferencia_notificacion', 'usuario_id')) {
            return;
        }

        Schema::table('preferencia_notificacion', function (Blueprint $table) {
            $table->dropForeign(['usuario_id']);
            try {
                $table->dropUnique('preferencia_notificacion_usuario_id_cliente_id_unique');
            } catch (\Throwable $e) {
            }
        });

        Schema::table('preferencia_notificacion', function (Blueprint $table) {
            $table->renameColumn('usuario_id', 'user_id');
        });

        Schema::table('preferencia_notificacion', function (Blueprint $table) {
            $table->unique(['user_id', 'cliente_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    private function rollbackPreferenciaNotificacion(): void
    {
        if (! Schema::hasTable('preferencia_notificacion') || ! Schema::hasColumn('preferencia_notificacion', 'user_id')) {
            return;
        }

        Schema::table('preferencia_notificacion', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            try {
                $table->dropUnique('preferencia_notificacion_user_id_cliente_id_unique');
            } catch (\Throwable $e) {
            }
        });

        Schema::table('preferencia_notificacion', function (Blueprint $table) {
            $table->renameColumn('user_id', 'usuario_id');
        });

        Schema::table('preferencia_notificacion', function (Blueprint $table) {
            $table->unique(['usuario_id', 'cliente_id']);
            $table->foreign('usuario_id')->references('id')->on('usuarios')->cascadeOnDelete();
        });
    }

    private function migrateMantenimiento(): void
    {
        if (! Schema::hasTable('mantenimiento') || ! Schema::hasColumn('mantenimiento', 'responsable')) {
            return;
        }

        Schema::table('mantenimiento', function (Blueprint $table) {
            $table->dropForeign(['responsable']);
        });

        Schema::table('mantenimiento', function (Blueprint $table) {
            $table->renameColumn('responsable', 'responsable_user_id');
        });

        Schema::table('mantenimiento', function (Blueprint $table) {
            $table->foreign('responsable_user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    private function rollbackMantenimiento(): void
    {
        if (! Schema::hasTable('mantenimiento') || ! Schema::hasColumn('mantenimiento', 'responsable_user_id')) {
            return;
        }

        Schema::table('mantenimiento', function (Blueprint $table) {
            $table->dropForeign(['responsable_user_id']);
        });

        Schema::table('mantenimiento', function (Blueprint $table) {
            $table->renameColumn('responsable_user_id', 'responsable');
        });

        Schema::table('mantenimiento', function (Blueprint $table) {
            $table->foreign('responsable')->references('id')->on('usuarios')->cascadeOnDelete();
        });
    }

    private function migrateTareaOperativa(): void
    {
        if (! Schema::hasTable('tarea_operativa') || ! Schema::hasColumn('tarea_operativa', 'asignada_a')) {
            return;
        }

        Schema::table('tarea_operativa', function (Blueprint $table) {
            $table->dropForeign(['asignada_a']);
        });

        Schema::table('tarea_operativa', function (Blueprint $table) {
            $table->renameColumn('asignada_a', 'asignada_a_user_id');
        });

        Schema::table('tarea_operativa', function (Blueprint $table) {
            $table->foreign('asignada_a_user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    private function rollbackTareaOperativa(): void
    {
        if (! Schema::hasTable('tarea_operativa') || ! Schema::hasColumn('tarea_operativa', 'asignada_a_user_id')) {
            return;
        }

        Schema::table('tarea_operativa', function (Blueprint $table) {
            $table->dropForeign(['asignada_a_user_id']);
        });

        Schema::table('tarea_operativa', function (Blueprint $table) {
            $table->renameColumn('asignada_a_user_id', 'asignada_a');
        });

        Schema::table('tarea_operativa', function (Blueprint $table) {
            $table->foreign('asignada_a')->references('id')->on('usuarios')->cascadeOnDelete();
        });
    }

    private function retargetEstadoAtraccion(): void
    {
        if (! Schema::hasTable('estado_atraccion') || ! Schema::hasColumn('estado_atraccion', 'registrado_por_id')) {
            return;
        }

        Schema::table('estado_atraccion', function (Blueprint $table) {
            $table->dropForeign(['registrado_por_id']);
        });

        Schema::table('estado_atraccion', function (Blueprint $table) {
            $table->foreign('registrado_por_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    private function rollbackEstadoAtraccion(): void
    {
        if (! Schema::hasTable('estado_atraccion') || ! Schema::hasColumn('estado_atraccion', 'registrado_por_id')) {
            return;
        }

        Schema::table('estado_atraccion', function (Blueprint $table) {
            $table->dropForeign(['registrado_por_id']);
        });

        Schema::table('estado_atraccion', function (Blueprint $table) {
            $table->foreign('registrado_por_id')->references('id')->on('usuarios')->cascadeOnDelete();
        });
    }

    private function retargetIncidente(): void
    {
        if (! Schema::hasTable('incidente') || ! Schema::hasColumn('incidente', 'reportado_por_id')) {
            return;
        }

        Schema::table('incidente', function (Blueprint $table) {
            $table->dropForeign(['reportado_por_id']);
        });

        Schema::table('incidente', function (Blueprint $table) {
            $table->foreign('reportado_por_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    private function rollbackIncidente(): void
    {
        if (! Schema::hasTable('incidente') || ! Schema::hasColumn('incidente', 'reportado_por_id')) {
            return;
        }

        Schema::table('incidente', function (Blueprint $table) {
            $table->dropForeign(['reportado_por_id']);
        });

        Schema::table('incidente', function (Blueprint $table) {
            $table->foreign('reportado_por_id')->references('id')->on('usuarios')->cascadeOnDelete();
        });
    }
};
