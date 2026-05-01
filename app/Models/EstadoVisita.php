<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoVisita extends Model
{
    protected $table = 'estados_visita';
    protected $fillable = ['nombre'];

    public function visitas(): HasMany
    {
        return $this->hasMany(Visita::class);
    }
}
