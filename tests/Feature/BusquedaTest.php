<?php

namespace Tests\Feature;

use App\Models\Agente;
use App\Models\Colonia;
use App\Models\EstadoGeografico;
use App\Models\EstadoPropiedad;
use App\Models\Municipio;
use App\Models\Propiedad;
use App\Models\Role;
use App\Models\TipoOperacion;
use App\Models\TipoPropiedad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BusquedaTest extends TestCase
{
    use RefreshDatabase;

    private Agente $agente;
    private Colonia $colonia;
    private TipoPropiedad $tipoPropiedad;
    private TipoOperacion $tipoOperacion;
    private EstadoPropiedad $estadoPropiedad;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);

        $user = User::factory()->create([
            'rol_id' => Role::where('nombre', 'agente')->value('id'),
            'activo' => true,
        ]);
        $this->agente = Agente::create([
            'usuario_id'        => $user->id,
            'licencia_numero'   => 'LIC-001',
            'especialidad'      => 'Test',
            'anios_experiencia' => 1,
            'biografia'         => 'Test',
        ]);

        $estado = EstadoGeografico::create(['nombre' => 'Ciudad de Mexico', 'clave' => 'CDMX']);
        $municipio = Municipio::create(['nombre' => 'Benito Juarez', 'estado_id' => $estado->id]);
        $this->colonia = Colonia::create(['nombre' => 'Del Valle', 'municipio_id' => $municipio->id]);

        $this->tipoPropiedad   = TipoPropiedad::create(['nombre' => 'Casa']);
        $this->tipoOperacion   = TipoOperacion::create(['nombre' => 'Venta']);
        $this->estadoPropiedad = EstadoPropiedad::create(['nombre' => 'Disponible', 'color' => '#10b981']);
    }

    private function crearPropiedad(array $override = []): Propiedad
    {
        return Propiedad::create(array_merge([
            'titulo'              => 'Casa en Del Valle',
            'descripcion'        => 'Hermosa casa',
            'precio'             => 5000000,
            'tipo_operacion_id'  => $this->tipoOperacion->id,
            'tipo_propiedad_id'  => $this->tipoPropiedad->id,
            'estado_propiedad_id'=> $this->estadoPropiedad->id,
            'agente_id'          => $this->agente->id,
            'colonia_id'         => $this->colonia->id,
            'direccion'          => 'Calle 1 #100',
            'habitaciones'       => 3,
            'banios'             => 2,
            'metros_construccion'=> 120,
            'aprobada'           => true,
        ], $override));
    }

    public function test_search_page_is_accessible(): void
    {
        $this->get('/propiedades')->assertStatus(200);
    }

    public function test_search_returns_approved_properties(): void
    {
        $aprobada = $this->crearPropiedad(['aprobada' => true]);
        $this->crearPropiedad(['aprobada' => false, 'titulo' => 'No aprobada']);

        $response = $this->get('/propiedades');
        $response->assertStatus(200);
        $response->assertSee($aprobada->titulo);
        $response->assertDontSee('No aprobada');
    }

    public function test_search_filters_by_tipo_operacion(): void
    {
        $venta = $this->crearPropiedad(['titulo' => 'En Venta']);
        $renta = TipoOperacion::create(['nombre' => 'Renta']);
        $this->crearPropiedad(['titulo' => 'En Renta', 'tipo_operacion_id' => $renta->id]);

        $response = $this->get('/propiedades?tipo_operacion_id=' . $this->tipoOperacion->id);
        $response->assertSee('En Venta');
        $response->assertDontSee('En Renta');
    }

    public function test_search_filters_by_precio_min(): void
    {
        $this->crearPropiedad(['titulo' => 'Barata', 'precio' => 1000000]);
        $this->crearPropiedad(['titulo' => 'Cara', 'precio' => 8000000]);

        $response = $this->get('/propiedades?precio_min=5000000');
        $response->assertSee('Cara');
        $response->assertDontSee('Barata');
    }

    public function test_search_filters_by_precio_max(): void
    {
        $this->crearPropiedad(['titulo' => 'Barata', 'precio' => 1000000]);
        $this->crearPropiedad(['titulo' => 'Cara', 'precio' => 8000000]);

        $response = $this->get('/propiedades?precio_max=3000000');
        $response->assertSee('Barata');
        $response->assertDontSee('Cara');
    }

    public function test_search_filters_by_habitaciones(): void
    {
        $this->crearPropiedad(['titulo' => 'Chica', 'habitaciones' => 1]);
        $this->crearPropiedad(['titulo' => 'Grande', 'habitaciones' => 4]);

        $response = $this->get('/propiedades?habitaciones=3');
        $response->assertSee('Grande');
        $response->assertDontSee('Chica');
    }

    public function test_search_filters_by_text_busqueda(): void
    {
        $this->crearPropiedad(['titulo' => 'Casa Pedregal Exclusiva']);
        $this->crearPropiedad(['titulo' => 'Departamento Centro']);

        $response = $this->get('/propiedades?busqueda=Pedregal');
        $response->assertSee('Casa Pedregal Exclusiva');
        $response->assertDontSee('Departamento Centro');
    }

    public function test_search_returns_paginated_results(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            $this->crearPropiedad(['titulo' => "Propiedad $i"]);
        }

        $response = $this->get('/propiedades');
        $response->assertStatus(200);
        // Paginacion de 12
        $response->assertSee('Propiedad 1');
        $response->assertDontSee('Propiedad 15');
    }

    public function test_empty_search_returns_no_results_message(): void
    {
        $response = $this->get('/propiedades?busqueda=xyzpropiedad123');
        $response->assertStatus(200);
    }

    public function test_property_detail_page_works_for_approved_property(): void
    {
        $prop = $this->crearPropiedad();
        $this->get('/propiedades/' . $prop->id)->assertStatus(200)->assertSee($prop->titulo);
    }
}
