<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckIn extends Model
{
    use HasFactory;

    protected $table = 'check_in';

    protected $fillable = [
        'boleto_id',
        'acceso_por_id',
        'escaneado_at',
        'punto_acceso',
        'resultado',
    ];

    protected $casts = [
        'escaneado_at' => 'datetime',
    ];

    public function boleto(): BelongsTo
    {
        return $this->belongsTo(Boleto::class, 'boleto_id');
    }

    public function accesoPor(): BelongsTo
    {
        return $this->belongsTo(Empleado::class, 'acceso_por_id');
    }
}
