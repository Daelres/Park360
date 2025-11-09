<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LecturaCola extends Model
{
    use HasFactory;

    protected $table = 'lectura_cola';

    protected $fillable = [
        'atraccion_id',
        'personas_en_cola',
        'tiempo_espera_min',
        'fuente',
    ];

    public function atraccion(): BelongsTo
    {
        return $this->belongsTo(Atraccion::class, 'atraccion_id');
    }
}
