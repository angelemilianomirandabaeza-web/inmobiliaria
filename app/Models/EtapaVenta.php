<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EtapaVenta extends Model
{
    protected $table = 'etapas_venta';
    protected $fillable = ['nombre', 'orden'];

    public function pipeline(): HasMany
    {
        return $this->hasMany(PipelineVenta::class, 'etapa_id');
    }
}
