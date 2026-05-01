<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanPublicacion extends Model
{
    protected $table = 'planes_publicacion';
    protected $fillable = [
        'nombre', 'max_propiedades', 'duracion_dias',
        'precio_plan', 'propiedades_destacadas', 'descripcion'
    ];

    protected $casts = ['propiedades_destacadas' => 'boolean'];

    public function suscripciones(): HasMany
    {
        return $this->hasMany(Suscripcion::class, 'plan_id');
    }
}
