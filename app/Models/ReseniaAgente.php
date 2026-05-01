<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReseniaAgente extends Model
{
    protected $table = 'resenias_agente';
    protected $fillable = ['agente_id', 'cliente_id', 'calificacion', 'comentario'];

    public function agente(): BelongsTo
    {
        return $this->belongsTo(Agente::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
