<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistorialPrecio extends Model
{
    protected $table = 'historial_precios';
    protected $fillable = ['propiedad_id', 'precio_anterior', 'precio_nuevo', 'fecha_cambio', 'motivo'];

    protected $casts = ['fecha_cambio' => 'date'];

    public function propiedad(): BelongsTo
    {
        return $this->belongsTo(Propiedad::class);
    }
}
