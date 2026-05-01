<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agente extends Model
{
    protected $table = 'agentes';
    protected $fillable = [
        'usuario_id', 'agencia_id', 'licencia_numero', 'biografia',
        'especialidad', 'anios_experiencia', 'calificacion_promedio', 'total_ventas'
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function agencia(): BelongsTo
    {
        return $this->belongsTo(Agencia::class);
    }

    public function propiedades(): HasMany
    {
        return $this->hasMany(Propiedad::class);
    }

    public function visitas(): HasMany
    {
        return $this->hasMany(Visita::class);
    }

    public function pipeline(): HasMany
    {
        return $this->hasMany(PipelineVenta::class);
    }

    public function resenias(): HasMany
    {
        return $this->hasMany(ReseniaAgente::class);
    }

    public function suscripciones(): HasMany
    {
        return $this->hasMany(Suscripcion::class);
    }

    public function suscripcionActiva(): HasOne
    {
        return $this->hasOne(Suscripcion::class)->where('activa', true)->latest();
    }

    public function contratos(): HasMany
    {
        return $this->hasMany(Contrato::class);
    }
}
