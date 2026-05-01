<?php

namespace Database\Seeders;

use App\Models\Colonia;
use App\Models\EstadoGeografico;
use App\Models\Municipio;
use Illuminate\Database\Seeder;

class UbicacionSeeder extends Seeder
{
    public function run(): void
    {
        $datos = [
            'Ciudad de Mexico' => [
                'Cuauhtemoc' => ['Roma Norte' => '06700', 'Condesa' => '06140', 'Juarez' => '06600'],
                'Miguel Hidalgo' => ['Polanco' => '11560', 'Lomas de Chapultepec' => '11000'],
                'Benito Juarez' => ['Del Valle' => '03100', 'Narvarte' => '03020'],
            ],
            'Jalisco' => [
                'Guadalajara' => ['Providencia' => '44630', 'Chapalita' => '44500', 'Centro' => '44100'],
                'Zapopan' => ['Andares' => '45116', 'Valle Real' => '45019'],
            ],
            'Nuevo Leon' => [
                'Monterrey' => ['San Pedro' => '66220', 'Cumbres' => '64619', 'Centro' => '64000'],
                'San Pedro Garza Garcia' => ['Del Valle' => '66220', 'Vista Hermosa' => '64620'],
            ],
            'Estado de Mexico' => [
                'Naucalpan' => ['Satelite' => '53100', 'Echegaray' => '53330'],
                'Toluca' => ['Centro Toluca' => '50000', 'Metepec Centro' => '52140'],
            ],
        ];

        foreach ($datos as $estadoNombre => $municipios) {
            $estado = EstadoGeografico::create(['nombre' => $estadoNombre]);

            foreach ($municipios as $municipioNombre => $colonias) {
                $municipio = Municipio::create([
                    'nombre' => $municipioNombre,
                    'estado_id' => $estado->id,
                ]);

                foreach ($colonias as $coloniaNombre => $cp) {
                    Colonia::create([
                        'nombre' => $coloniaNombre,
                        'codigo_postal' => $cp,
                        'municipio_id' => $municipio->id,
                    ]);
                }
            }
        }
    }
}
