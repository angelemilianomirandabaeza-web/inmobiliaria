<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoGeografico extends Model
{
    protected $table = 'estados_geograficos';
    protected $fillable = ['nombre'];

    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class, 'estado_id');
    }
}
