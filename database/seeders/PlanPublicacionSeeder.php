<?php

namespace Database\Seeders;

use App\Models\PlanPublicacion;
use Illuminate\Database\Seeder;

class PlanPublicacionSeeder extends Seeder
{
    public function run(): void
    {
        $planes = [
            [
                'nombre' => 'Gratuito',
                'max_propiedades' => 3,
                'duracion_dias' => 30,
                'precio_plan' => 0,
                'propiedades_destacadas' => false,
                'descripcion' => 'Plan basico para empezar. Hasta 3 propiedades publicadas.',
            ],
            [
                'nombre' => 'Estandar',
                'max_propiedades' => 15,
                'duracion_dias' => 30,
                'precio_plan' => 499.00,
                'propiedades_destacadas' => false,
                'descripcion' => 'Para agentes activos. Hasta 15 propiedades simultaneas.',
            ],
            [
                'nombre' => 'Premium',
                'max_propiedades' => 50,
                'duracion_dias' => 30,
                'precio_plan' => 1499.00,
                'propiedades_destacadas' => true,
                'descripcion' => 'Plan profesional con propiedades destacadas y prioridad en busquedas.',
            ],
        ];

        foreach ($planes as $plan) {
            PlanPublicacion::create($plan);
        }
    }
}
