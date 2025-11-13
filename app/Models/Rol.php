<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rol';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function usuarios(): BelongsToMany
    {
    return $this->belongsToMany(User::class, 'user_rol', 'rol_id', 'user_id')->withTimestamps();
    }

    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'permiso_rol', 'rol_id', 'permiso_id')->withTimestamps();
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(UserRol::class, 'rol_id');
    }
}
