<?php

namespace Database\Seeders;

use App\Models\Agente;
use App\Models\PlanPublicacion;
use App\Models\Suscripcion;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@inmobiliaria.com',
            'password' => Hash::make('password'),
            'rol_id' => 1, // admin
            'telefono' => '5512345678',
            'activo' => true,
        ]);

        // Agentes
        $agentes = [
            [
                'name' => 'Carlos Ramirez',
                'email' => 'carlos@inmobiliaria.com',
                'especialidad' => 'Residencial de lujo',
                'anios_experiencia' => 8,
            ],
            [
                'name' => 'Maria Lopez',
                'email' => 'maria@inmobiliaria.com',
                'especialidad' => 'Departamentos urbanos',
                'anios_experiencia' => 5,
            ],
            [
                'name' => 'Jorge Hernandez',
                'email' => 'jorge@inmobiliaria.com',
                'especialidad' => 'Locales comerciales',
                'anios_experiencia' => 12,
            ],
        ];

        foreach ($agentes as $i => $a) {
            $user = User::create([
                'name' => $a['name'],
                'email' => $a['email'],
                'password' => Hash::make('password'),
                'rol_id' => 2, // agente
                'telefono' => '55' . rand(10000000, 99999999),
                'activo' => true,
            ]);

            $agente = Agente::create([
                'usuario_id' => $user->id,
                'licencia_numero' => 'LIC-' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'especialidad' => $a['especialidad'],
                'anios_experiencia' => $a['anios_experiencia'],
                'biografia' => 'Agente profesional con ' . $a['anios_experiencia'] . ' anios de experiencia.',
            ]);

            // Suscripcion premium
            Suscripcion::create([
                'agente_id' => $agente->id,
                'plan_id' => 3,
                'fecha_inicio' => now(),
                'fecha_fin' => now()->addDays(30),
                'activa' => true,
            ]);
        }

        // Clientes
        $clientes = [
            ['name' => 'Ana Garcia',     'email' => 'ana@cliente.com'],
            ['name' => 'Luis Torres',    'email' => 'luis@cliente.com'],
            ['name' => 'Patricia Silva', 'email' => 'patricia@cliente.com'],
        ];

        foreach ($clientes as $c) {
            User::create([
                'name' => $c['name'],
                'email' => $c['email'],
                'password' => Hash::make('password'),
                'rol_id' => 3, // cliente
                'telefono' => '55' . rand(10000000, 99999999),
                'activo' => true,
            ]);
        }
    }
}
