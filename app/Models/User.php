<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
        'telefono',
        'foto_perfil',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public function agente(): HasOne
    {
        return $this->hasOne(Agente::class, 'usuario_id');
    }

    public function agencia(): HasOne
    {
        return $this->hasOne(Agencia::class, 'usuario_id');
    }

    public function favoritos(): HasMany
    {
        return $this->hasMany(Favorito::class, 'cliente_id');
    }

    public function propiedadesFavoritas(): BelongsToMany
    {
        return $this->belongsToMany(Propiedad::class, 'favoritos', 'cliente_id', 'propiedad_id')
                    ->withTimestamps();
    }

    public function visitas(): HasMany
    {
        return $this->hasMany(Visita::class, 'cliente_id');
    }

    public function alertas(): HasMany
    {
        return $this->hasMany(Alerta::class, 'cliente_id');
    }

    public function isAdmin(): bool
    {
        return $this->rol && $this->rol->nombre === 'admin';
    }

    public function isAgente(): bool
    {
        return $this->rol && $this->rol->nombre === 'agente';
    }

    public function isCliente(): bool
    {
        return $this->rol && $this->rol->nombre === 'cliente';
    }
}
