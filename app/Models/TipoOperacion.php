<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoOperacion extends Model
{
    protected $table = 'tipos_operacion';
    protected $fillable = ['nombre'];

    public function propiedades(): HasMany
    {
        return $this->hasMany(Propiedad::class);
    }
}
