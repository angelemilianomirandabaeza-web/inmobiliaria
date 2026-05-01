<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoPropiedad extends Model
{
    protected $table = 'estados_propiedad';
    protected $fillable = ['nombre', 'color'];

    public function propiedades(): HasMany
    {
        return $this->hasMany(Propiedad::class);
    }
}
