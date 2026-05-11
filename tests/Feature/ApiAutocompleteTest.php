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

class ApiAutocompleteTest extends TestCase
{
    use RefreshDatabase;

    private Agente $agente;
    private Colonia $colonia;
    private Municipio $municipio;

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
        $this->municipio = Municipio::create(['nombre' => 'Benito Juarez', 'estado_id' => $estado->id]);
        $this->colonia   = Colonia::create(['nombre' => 'Del Valle', 'municipio_id' => $this->municipio->id]);
    }

    private function crearPropiedad(array $override = []): Propiedad
    {
        $tipo     = TipoPropiedad::firstOrCreate(['nombre' => 'Casa']);
        $op       = TipoOperacion::firstOrCreate(['nombre' => 'Venta']);
        $estado   = EstadoPropiedad::firstOrCreate(['nombre' => 'Disponible'], ['color' => '#10b981']);

        return Propiedad::create(array_merge([
            'titulo'              => 'Casa en Del Valle',
            'descripcion'        => 'Hermosa casa',
            'precio'             => 5000000,
            'tipo_operacion_id'  => $op->id,
            'tipo_propiedad_id'  => $tipo->id,
            'estado_propiedad_id'=> $estado->id,
            'agente_id'          => $this->agente->id,
            'colonia_id'         => $this->colonia->id,
            'direccion'          => 'Calle 1 #100',
            'aprobada'           => true,
        ], $override));
    }

    public function test_autocomplete_requires_minimum_two_chars(): void
    {
        $response = $this->getJson('/api/autocomplete?q=a');
        $response->assertStatus(200)->assertJson(['results' => []]);
    }

    public function test_autocomplete_returns_matching_properties(): void
    {
        $this->crearPropiedad(['titulo' => 'Casa Pedregal Hermosa']);

        $response = $this->getJson('/api/autocomplete?q=Pedregal');
        $response->assertStatus(200);
        $data = $response->json();
        $this->assertNotEmpty($data['results']);
        $types = collect($data['results'])->pluck('type')->all();
        $this->assertContains('propiedad', $types);
    }

    public function test_autocomplete_does_not_return_unapproved_properties(): void
    {
        $this->crearPropiedad(['titulo' => 'Casa Oculta', 'aprobada' => false]);

        $response = $this->getJson('/api/autocomplete?q=Oculta');
        $response->assertStatus(200);
        $data = $response->json();
        $propiedades = collect($data['results'])->where('type', 'propiedad');
        $this->assertEmpty($propiedades);
    }

    public function test_autocomplete_returns_matching_colonias(): void
    {
        $response = $this->getJson('/api/autocomplete?q=Del Valle');
        $response->assertStatus(200);
        $data = $response->json();
        $colonias = collect($data['results'])->where('type', 'colonia');
        $this->assertNotEmpty($colonias);
    }

    public function test_autocomplete_returns_matching_municipios(): void
    {
        $response = $this->getJson('/api/autocomplete?q=Benito');
        $response->assertStatus(200);
        $data = $response->json();
        $municipios = collect($data['results'])->where('type', 'municipio');
        $this->assertNotEmpty($municipios);
    }

    public function test_autocomplete_returns_colonia_count(): void
    {
        $this->crearPropiedad(['aprobada' => true]);
        $this->crearPropiedad(['aprobada' => true]);

        $response = $this->getJson('/api/autocomplete?q=Del Valle');
        $response->assertStatus(200);
        $data = $response->json();
        $colonia = collect($data['results'])->where('type', 'colonia')->first();
        $this->assertNotNull($colonia);
        $this->assertStringContainsString('2', $colonia['price']);
    }

    public function test_autocomplete_empty_query_returns_empty(): void
    {
        $response = $this->getJson('/api/autocomplete?q=');
        $response->assertStatus(200)->assertJson(['results' => []]);
    }

    public function test_quick_view_returns_html_with_property_data(): void
    {
        $prop = $this->crearPropiedad(['titulo' => 'Casa Quick View Test']);
        $response = $this->get('/api/quick-view/' . $prop->id);
        $response->assertStatus(200);
        $response->assertSee('Casa Quick View Test');
    }

    public function test_quick_view_returns_404_for_unapproved_property(): void
    {
        $prop = $this->crearPropiedad(['aprobada' => false]);
        $this->get('/api/quick-view/' . $prop->id)->assertStatus(404);
    }
}
