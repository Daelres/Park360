<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permiso';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Rol::class, 'permiso_rol', 'permiso_id', 'rol_id')->withTimestamps();
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(PermisoRol::class, 'permiso_id');
    }
}
