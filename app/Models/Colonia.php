<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Colonia extends Model
{
    protected $table = 'colonias';
    protected $fillable = ['nombre', 'codigo_postal', 'municipio_id'];

    public function municipio(): BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }

    public function propiedades(): HasMany
    {
        return $this->hasMany(Propiedad::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre}, {$this->municipio->nombre}, {$this->municipio->estado->nombre}";
    }
}
