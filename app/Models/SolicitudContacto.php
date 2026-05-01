<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudContacto extends Model
{
    protected $table = 'solicitudes_contacto';
    protected $fillable = [
        'propiedad_id', 'cliente_id', 'nombre_contacto',
        'email_contacto', 'telefono_contacto', 'mensaje', 'respondida'
    ];

    protected $casts = ['respondida' => 'boolean'];

    public function propiedad(): BelongsTo
    {
        return $this->belongsTo(Propiedad::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
