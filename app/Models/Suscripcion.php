<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suscripcion extends Model
{
    protected $table = 'suscripciones';
    protected $fillable = ['agente_id', 'plan_id', 'fecha_inicio', 'fecha_fin', 'activa'];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activa' => 'boolean',
    ];

    public function agente(): BelongsTo
    {
        return $this->belongsTo(Agente::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(PlanPublicacion::class, 'plan_id');
    }
}
