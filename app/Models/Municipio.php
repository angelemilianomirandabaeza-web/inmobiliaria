<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $fillable = ['nombre', 'estado_id'];

    public function estado(): BelongsTo
    {
        return $this->belongsTo(EstadoGeografico::class, 'estado_id');
    }

    public function colonias(): HasMany
    {
        return $this->hasMany(Colonia::class);
    }

    public function propiedades(): HasManyThrough
    {
        return $this->hasManyThrough(Propiedad::class, Colonia::class);
    }
}
