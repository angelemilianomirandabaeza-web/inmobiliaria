<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alerta extends Model
{
    protected $table = 'alertas';
    protected $fillable = [
        'cliente_id', 'tipo_propiedad_id', 'tipo_operacion_id', 'colonia_id',
        'precio_min', 'precio_max', 'habitaciones_min', 'metros_min', 'activa'
    ];

    protected $casts = ['activa' => 'boolean'];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function tipoPropiedad(): BelongsTo
    {
        return $this->belongsTo(TipoPropiedad::class);
    }

    public function tipoOperacion(): BelongsTo
    {
        return $this->belongsTo(TipoOperacion::class);
    }

    public function colonia(): BelongsTo
    {
        return $this->belongsTo(Colonia::class);
    }
}
