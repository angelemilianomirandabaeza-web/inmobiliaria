<?php

namespace Database\Seeders;

use App\Models\Amenidad;
use App\Models\EstadoPropiedad;
use App\Models\EstadoVisita;
use App\Models\EtapaVenta;
use App\Models\TipoOperacion;
use App\Models\TipoPropiedad;
use Illuminate\Database\Seeder;

class CatalogoSeeder extends Seeder
{
    public function run(): void
    {
        // Tipos de propiedad
        $tipos = ['Casa', 'Departamento', 'Terreno', 'Local Comercial', 'Oficina', 'Bodega', 'Rancho'];
        foreach ($tipos as $t) {
            TipoPropiedad::create(['nombre' => $t]);
        }

        // Tipos de operacion
        $operaciones = ['Venta', 'Renta', 'Traspaso', 'Preventa'];
        foreach ($operaciones as $op) {
            TipoOperacion::create(['nombre' => $op]);
        }

        // Estados de propiedad
        $estados = [
            ['nombre' => 'Disponible',     'color' => '#10b981'],
            ['nombre' => 'Vendida',        'color' => '#ef4444'],
            ['nombre' => 'Rentada',        'color' => '#3b82f6'],
            ['nombre' => 'En Negociacion', 'color' => '#f59e0b'],
            ['nombre' => 'Suspendida',     'color' => '#6b7280'],
        ];
        foreach ($estados as $e) {
            EstadoPropiedad::create($e);
        }

        // Estados de visita
        $estadosVisita = ['Pendiente', 'Confirmada', 'Realizada', 'Cancelada', 'No Asistio'];
        foreach ($estadosVisita as $ev) {
            EstadoVisita::create(['nombre' => $ev]);
        }

        // Etapas de venta
        $etapas = [
            ['nombre' => 'Prospecto',        'orden' => 1],
            ['nombre' => 'Visita Agendada',  'orden' => 2],
            ['nombre' => 'Visita Realizada', 'orden' => 3],
            ['nombre' => 'Negociacion',      'orden' => 4],
            ['nombre' => 'Documentacion',    'orden' => 5],
            ['nombre' => 'Cierre',           'orden' => 6],
        ];
        foreach ($etapas as $et) {
            EtapaVenta::create($et);
        }

        // Amenidades
        $amenidades = [
            'Alberca', 'Gimnasio', 'Jardin', 'Terraza', 'Roof Garden',
            'Seguridad 24/7', 'Estacionamiento Visitas', 'Area de Juegos',
            'Salon de Eventos', 'Elevador', 'Bodega', 'Cuarto de Servicio',
            'Gas Natural', 'Cisterna', 'Paneles Solares', 'Aire Acondicionado',
            'Calentador Solar', 'Pet Friendly', 'Vigilancia', 'Caseta de Acceso'
        ];
        foreach ($amenidades as $a) {
            Amenidad::create(['nombre' => $a]);
        }
    }
}
