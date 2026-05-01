<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PipelineVenta extends Model
{
    protected $table = 'pipeline_ventas';
    protected $fillable = [
        'propiedad_id', 'cliente_id', 'agente_id',
        'etapa_id', 'notas', 'fecha_estimada_cierre'
    ];

    protected $casts = ['fecha_estimada_cierre' => 'date'];

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

    public function etapa(): BelongsTo
    {
        return $this->belongsTo(EtapaVenta::class, 'etapa_id');
    }
}
