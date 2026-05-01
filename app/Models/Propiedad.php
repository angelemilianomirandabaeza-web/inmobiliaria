<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Propiedad extends Model
{
    protected $table = 'propiedades';
    protected $fillable = [
        'titulo', 'descripcion', 'precio', 'precio_anterior',
        'tipo_operacion_id', 'tipo_propiedad_id', 'estado_propiedad_id',
        'agente_id', 'colonia_id', 'direccion', 'latitud', 'longitud',
        'metros_construccion', 'metros_terreno', 'habitaciones', 'banios',
        'medios_banios', 'estacionamientos', 'antiguedad_anios', 'piso',
        'total_pisos', 'amueblado', 'destacada', 'aprobada', 'visitas_contador'
    ];

    protected $casts = [
        'amueblado'  => 'boolean',
        'destacada'  => 'boolean',
        'aprobada'   => 'boolean',
        'precio'     => 'decimal:2',
        'precio_anterior' => 'decimal:2',
    ];

    public function agente(): BelongsTo
    {
        return $this->belongsTo(Agente::class);
    }

    public function tipoPropiedad(): BelongsTo
    {
        return $this->belongsTo(TipoPropiedad::class);
    }

    public function tipoOperacion(): BelongsTo
    {
        return $this->belongsTo(TipoOperacion::class);
    }

    public function estadoPropiedad(): BelongsTo
    {
        return $this->belongsTo(EstadoPropiedad::class);
    }

    public function colonia(): BelongsTo
    {
        return $this->belongsTo(Colonia::class);
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(ImagenPropiedad::class)->orderBy('orden');
    }

    public function imagenPrincipal(): HasOne
    {
        return $this->hasOne(ImagenPropiedad::class)->where('es_principal', true);
    }

    public function amenidades(): BelongsToMany
    {
        return $this->belongsToMany(Amenidad::class, 'propiedad_amenidad');
    }

    public function visitas(): HasMany
    {
        return $this->hasMany(Visita::class);
    }

    public function favoritos(): HasMany
    {
        return $this->hasMany(Favorito::class);
    }

    public function historialPrecios(): HasMany
    {
        return $this->hasMany(HistorialPrecio::class)->orderByDesc('fecha_cambio');
    }

    public function solicitudesContacto(): HasMany
    {
        return $this->hasMany(SolicitudContacto::class);
    }

    public function pipeline(): HasMany
    {
        return $this->hasMany(PipelineVenta::class);
    }

    public function getPrecioFormateadoAttribute(): string
    {
        return '$' . number_format((float)$this->precio, 0, '.', ',');
    }

    public function scopeAprobadas($query)
    {
        return $query->where('aprobada', true);
    }

    public function scopeDestacadas($query)
    {
        return $query->where('destacada', true);
    }
}
