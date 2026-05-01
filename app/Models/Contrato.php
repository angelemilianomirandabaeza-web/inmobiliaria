<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contrato extends Model
{
    protected $table = 'contratos';
    protected $fillable = [
        'propiedad_id', 'cliente_id', 'agente_id',
        'tipo_contrato', 'precio_acordado', 'fecha_firma',
        'fecha_entrega', 'comision_agente', 'archivo_pdf'
    ];

    protected $casts = [
        'fecha_firma' => 'date',
        'fecha_entrega' => 'date',
    ];

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
}
