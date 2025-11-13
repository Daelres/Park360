<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SesionSSO extends Model
{
    use HasFactory;

    protected $table = 'sesion_s_s_o';

    protected $fillable = [
    'user_id',
        'proveedor',
        'oidc_sub',
        'exp_at',
        'refresh_token',
    ];

    protected $casts = [
        'exp_at' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
    return $this->belongsTo(User::class, 'user_id');
    }
}
