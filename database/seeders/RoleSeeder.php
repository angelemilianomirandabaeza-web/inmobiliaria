<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'admin',    'descripcion' => 'Administrador del sistema'],
            ['nombre' => 'agente',   'descripcion' => 'Agente inmobiliario'],
            ['nombre' => 'cliente',  'descripcion' => 'Cliente final'],
            ['nombre' => 'agencia',  'descripcion' => 'Dueño de agencia inmobiliaria'],
        ];

        foreach ($roles as $rol) {
            Role::create($rol);
        }
    }
}
