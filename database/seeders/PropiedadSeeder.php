<?php

namespace Database\Seeders;

use App\Models\Amenidad;
use App\Models\Colonia;
use App\Models\ImagenPropiedad;
use App\Models\Propiedad;
use Illuminate\Database\Seeder;

class PropiedadSeeder extends Seeder
{
    public function run(): void
    {
        $propiedades = [
            [
                'titulo' => 'Casa moderna en Polanco con jardin',
                'descripcion' => 'Hermosa casa de 3 niveles con acabados de lujo, jardin amplio y excelente ubicacion en una de las zonas mas exclusivas.',
                'precio' => 12500000,
                'tipo_operacion_id' => 1, // Venta
                'tipo_propiedad_id' => 1, // Casa
                'estado_propiedad_id' => 1,
                'agente_id' => 1,
                'metros_construccion' => 380,
                'metros_terreno' => 450,
                'habitaciones' => 4,
                'banios' => 4,
                'medios_banios' => 1,
                'estacionamientos' => 3,
                'antiguedad_anios' => 5,
                'destacada' => true,
                'colonia_nombre' => 'Polanco',
            ],
            [
                'titulo' => 'Departamento en Roma Norte amueblado',
                'descripcion' => 'Departamento totalmente amueblado en edificio moderno con todas las amenidades. Listo para habitar.',
                'precio' => 28000,
                'tipo_operacion_id' => 2, // Renta
                'tipo_propiedad_id' => 2, // Departamento
                'estado_propiedad_id' => 1,
                'agente_id' => 2,
                'metros_construccion' => 85,
                'habitaciones' => 2,
                'banios' => 2,
                'estacionamientos' => 1,
                'piso' => 7,
                'total_pisos' => 12,
                'amueblado' => true,
                'destacada' => true,
                'colonia_nombre' => 'Roma Norte',
            ],
            [
                'titulo' => 'Casa familiar en Providencia, Guadalajara',
                'descripcion' => 'Casa amplia ideal para familias en zona tranquila y cercana a escuelas, parques y centros comerciales.',
                'precio' => 7800000,
                'tipo_operacion_id' => 1,
                'tipo_propiedad_id' => 1,
                'estado_propiedad_id' => 1,
                'agente_id' => 1,
                'metros_construccion' => 280,
                'metros_terreno' => 320,
                'habitaciones' => 4,
                'banios' => 3,
                'estacionamientos' => 2,
                'antiguedad_anios' => 10,
                'colonia_nombre' => 'Providencia',
            ],
            [
                'titulo' => 'Local comercial en Centro Monterrey',
                'descripcion' => 'Local comercial en planta baja con excelente afluencia peatonal. Ideal para retail.',
                'precio' => 35000,
                'tipo_operacion_id' => 2,
                'tipo_propiedad_id' => 4, // Local Comercial
                'estado_propiedad_id' => 1,
                'agente_id' => 3,
                'metros_construccion' => 120,
                'banios' => 1,
                'destacada' => true,
                'colonia_nombre' => 'Centro',
            ],
            [
                'titulo' => 'Departamento de lujo en Condesa',
                'descripcion' => 'Penthouse con roof garden privado, vista panoramica y los mejores acabados.',
                'precio' => 18500000,
                'tipo_operacion_id' => 1,
                'tipo_propiedad_id' => 2,
                'estado_propiedad_id' => 1,
                'agente_id' => 2,
                'metros_construccion' => 220,
                'habitaciones' => 3,
                'banios' => 3,
                'medios_banios' => 1,
                'estacionamientos' => 2,
                'piso' => 10,
                'total_pisos' => 10,
                'destacada' => true,
                'colonia_nombre' => 'Condesa',
            ],
            [
                'titulo' => 'Terreno residencial en Valle Real',
                'descripcion' => 'Terreno plano listo para construir en privada con seguridad 24/7.',
                'precio' => 4500000,
                'tipo_operacion_id' => 1,
                'tipo_propiedad_id' => 3, // Terreno
                'estado_propiedad_id' => 1,
                'agente_id' => 3,
                'metros_terreno' => 600,
                'colonia_nombre' => 'Valle Real',
            ],
            [
                'titulo' => 'Casa con alberca en San Pedro',
                'descripcion' => 'Casa de un nivel con alberca, jardin y zona BBQ. Perfecta para entretener.',
                'precio' => 9500000,
                'tipo_operacion_id' => 1,
                'tipo_propiedad_id' => 1,
                'estado_propiedad_id' => 1,
                'agente_id' => 1,
                'metros_construccion' => 320,
                'metros_terreno' => 500,
                'habitaciones' => 4,
                'banios' => 3,
                'medios_banios' => 1,
                'estacionamientos' => 3,
                'antiguedad_anios' => 7,
                'colonia_nombre' => 'San Pedro',
            ],
            [
                'titulo' => 'Oficina equipada en Andares',
                'descripcion' => 'Oficina con mobiliario incluido, sala de juntas y cubiculos privados.',
                'precio' => 25000,
                'tipo_operacion_id' => 2,
                'tipo_propiedad_id' => 5, // Oficina
                'estado_propiedad_id' => 1,
                'agente_id' => 2,
                'metros_construccion' => 95,
                'banios' => 2,
                'estacionamientos' => 2,
                'amueblado' => true,
                'piso' => 5,
                'total_pisos' => 15,
                'colonia_nombre' => 'Andares',
            ],
        ];

        foreach ($propiedades as $i => $p) {
            $coloniaNombre = $p['colonia_nombre'];
            unset($p['colonia_nombre']);

            $colonia = Colonia::where('nombre', $coloniaNombre)->first();
            if (!$colonia) {
                $colonia = Colonia::first(); // fallback
            }

            $p['colonia_id'] = $colonia->id;
            $p['direccion'] = 'Calle Principal #' . rand(100, 999);
            $p['latitud'] = 19.4326 + (rand(-1000, 1000) / 10000);
            $p['longitud'] = -99.1332 + (rand(-1000, 1000) / 10000);
            $p['aprobada'] = true;
            $p['visitas_contador'] = rand(50, 500);

            $propiedad = Propiedad::create($p);

            // Imagen principal placeholder
            ImagenPropiedad::create([
                'propiedad_id' => $propiedad->id,
                'url_imagen' => 'https://picsum.photos/seed/prop' . $propiedad->id . '/800/600',
                'es_principal' => true,
                'orden' => 0,
            ]);

            // Imagenes adicionales
            for ($j = 1; $j <= 4; $j++) {
                ImagenPropiedad::create([
                    'propiedad_id' => $propiedad->id,
                    'url_imagen' => 'https://picsum.photos/seed/prop' . $propiedad->id . 'i' . $j . '/800/600',
                    'es_principal' => false,
                    'orden' => $j,
                ]);
            }

            // Amenidades aleatorias (3-7 por propiedad)
            $cantidadAmenidades = rand(3, 7);
            $amenidadesAleatorias = Amenidad::inRandomOrder()->limit($cantidadAmenidades)->pluck('id');
            $propiedad->amenidades()->attach($amenidadesAleatorias);
        }
    }
}
