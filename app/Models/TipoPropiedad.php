<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoPropiedad extends Model
{
    protected $table = 'tipos_propiedad';
    protected $fillable = ['nombre', 'icono'];

    public function propiedades(): HasMany
    {
        return $this->hasMany(Propiedad::class);
    }
}
