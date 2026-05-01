<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agencia extends Model
{
    protected $table = 'agencias';
    protected $fillable = [
        'nombre', 'logo', 'descripcion', 'telefono', 'email',
        'direccion', 'sitio_web', 'usuario_id', 'activo'
    ];

    protected $casts = ['activo' => 'boolean'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function agentes(): HasMany
    {
        return $this->hasMany(Agente::class);
    }
}
