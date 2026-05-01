<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenidad extends Model
{
    protected $table = 'amenidades';
    protected $fillable = ['nombre', 'icono'];

    public function propiedades(): BelongsToMany
    {
        return $this->belongsToMany(Propiedad::class, 'propiedad_amenidad');
    }
}
