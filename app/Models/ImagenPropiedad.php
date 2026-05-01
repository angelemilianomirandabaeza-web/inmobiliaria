<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenPropiedad extends Model
{
    protected $table = 'imagenes_propiedad';
    protected $fillable = ['propiedad_id', 'url_imagen', 'es_principal', 'orden'];

    protected $casts = ['es_principal' => 'boolean'];

    public function propiedad(): BelongsTo
    {
        return $this->belongsTo(Propiedad::class);
    }
}
