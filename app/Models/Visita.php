<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visita extends Model
{
    protected $table = 'visitas';
    protected $fillable = [
        'propiedad_id', 'cliente_id', 'agente_id',
        'fecha_visita', 'hora_inicio', 'hora_fin',
        'estado_visita_id', 'notas_cliente', 'notas_agente'
    ];

    protected $casts = ['fecha_visita' => 'date'];

    public function propiedad(): BelongsTo
    {
        return $this->belongsTo(Propiedad::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function agente(): BelongsTo
    {
        return $this->belongsTo(Agente::class);
    }

    public function estadoVisita(): BelongsTo
    {
        return $this->belongsTo(EstadoVisita::class);
    }
}
