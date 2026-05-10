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

class PropiedadAgenteTest extends TestCase
{
    use RefreshDatabase;

    private User $userAgente;
    private Agente $agente;
    private Colonia $colonia;
    private array $catalogos;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);

        $this->userAgente = User::factory()->create([
            'rol_id' => Role::where('nombre', 'agente')->value('id'),
            'activo' => true,
        ]);
        $this->agente = Agente::create([
            'usuario_id'        => $this->userAgente->id,
            'licencia_numero'   => 'LIC-001',
            'especialidad'      => 'Test',
            'anios_experiencia' => 1,
            'biografia'         => 'Test',
        ]);

        $estado    = EstadoGeografico::create(['nombre' => 'CDMX', 'clave' => 'CDMX']);
        $municipio = Municipio::create(['nombre' => 'BJ', 'estado_id' => $estado->id]);
        $this->colonia = Colonia::create(['nombre' => 'Del Valle', 'municipio_id' => $municipio->id]);

        $this->catalogos = [
            'tipo_operacion_id'  => TipoOperacion::create(['nombre' => 'Venta'])->id,
            'tipo_propiedad_id'  => TipoPropiedad::create(['nombre' => 'Casa'])->id,
            'estado_propiedad_id'=> EstadoPropiedad::create(['nombre' => 'Disponible', 'color' => '#10b981'])->id,
        ];
    }

    private function formData(array $override = []): array
    {
        return array_merge([
            'titulo'              => 'Casa de Prueba',
            'descripcion'        => 'Descripcion de prueba',
            'precio'             => 3000000,
            'colonia_id'         => $this->colonia->id,
            'direccion'          => 'Calle Test 123',
            'habitaciones'       => 3,
            'banios'             => 2,
            'metros_construccion'=> 100,
        ], $this->catalogos, $override);
    }

    private function crearPropiedad(array $override = []): Propiedad
    {
        return Propiedad::create(array_merge([
            'titulo'              => 'Casa Test',
            'descripcion'        => 'Test',
            'precio'             => 2000000,
            'agente_id'          => $this->agente->id,
            'colonia_id'         => $this->colonia->id,
            'direccion'          => 'Calle 1',
            'aprobada'           => false,
        ], $this->catalogos, $override));
    }

    // ── INDEX ──────────────────────────────────────────────────────

    public function test_agente_can_list_own_properties(): void
    {
        $this->crearPropiedad(['titulo' => 'Mi Propiedad']);

        $this->actingAs($this->userAgente)
            ->get('/agente/propiedades')
            ->assertStatus(200)
            ->assertSee('Mi Propiedad');
    }

    // ── CREATE / STORE ─────────────────────────────────────────────

    public function test_agente_can_view_create_form(): void
    {
        $this->actingAs($this->userAgente)
            ->get('/agente/propiedades/create')
            ->assertStatus(200);
    }

    public function test_agente_can_create_property(): void
    {
        $this->actingAs($this->userAgente)
            ->post('/agente/propiedades', $this->formData(['titulo' => 'Casa Nueva']))
            ->assertRedirect('/agente/propiedades');

        $this->assertDatabaseHas('propiedades', [
            'titulo'    => 'Casa Nueva',
            'agente_id' => $this->agente->id,
            'aprobada'  => false,
        ]);
    }

    public function test_create_property_requires_titulo(): void
    {
        $this->actingAs($this->userAgente)
            ->post('/agente/propiedades', $this->formData(['titulo' => '']))
            ->assertSessionHasErrors('titulo');
    }

    public function test_create_property_requires_valid_precio(): void
    {
        $this->actingAs($this->userAgente)
            ->post('/agente/propiedades', $this->formData(['precio' => -100]))
            ->assertSessionHasErrors('precio');
    }

    public function test_new_property_is_not_approved(): void
    {
        $this->actingAs($this->userAgente)
            ->post('/agente/propiedades', $this->formData());

        $propiedad = Propiedad::where('agente_id', $this->agente->id)->first();
        $this->assertFalse((bool) $propiedad->aprobada);
    }

    // ── EDIT / UPDATE ──────────────────────────────────────────────

    public function test_agente_can_edit_own_property(): void
    {
        $prop = $this->crearPropiedad();
        $this->actingAs($this->userAgente)
            ->get('/agente/propiedades/' . $prop->id . '/edit')
            ->assertStatus(200);
    }

    public function test_agente_can_update_own_property(): void
    {
        $prop = $this->crearPropiedad();

        $this->actingAs($this->userAgente)
            ->put('/agente/propiedades/' . $prop->id, $this->formData(['titulo' => 'Titulo Actualizado']))
            ->assertRedirect('/agente/propiedades');

        $this->assertDatabaseHas('propiedades', [
            'id'     => $prop->id,
            'titulo' => 'Titulo Actualizado',
        ]);
    }

    public function test_price_change_creates_history_record(): void
    {
        $prop = $this->crearPropiedad(['precio' => 2000000]);

        $this->actingAs($this->userAgente)
            ->put('/agente/propiedades/' . $prop->id, $this->formData(['precio' => 3000000]));

        $this->assertDatabaseHas('historial_precios', [
            'propiedad_id'   => $prop->id,
            'precio_anterior'=> 2000000,
            'precio_nuevo'   => 3000000,
        ]);
    }

    public function test_agente_cannot_edit_another_agents_property(): void
    {
        $otroUser = User::factory()->create([
            'rol_id' => Role::where('nombre', 'agente')->value('id'),
            'activo' => true,
        ]);
        $otroAgente = Agente::create([
            'usuario_id'        => $otroUser->id,
            'licencia_numero'   => 'LIC-002',
            'especialidad'      => 'Test',
            'anios_experiencia' => 1,
            'biografia'         => 'Test',
        ]);
        $propAjena = $this->crearPropiedad(['agente_id' => $otroAgente->id]);

        $this->actingAs($this->userAgente)
            ->get('/agente/propiedades/' . $propAjena->id . '/edit')
            ->assertStatus(403);
    }

    // ── DELETE ─────────────────────────────────────────────────────

    public function test_agente_can_delete_own_property(): void
    {
        $prop = $this->crearPropiedad();

        $this->actingAs($this->userAgente)
            ->delete('/agente/propiedades/' . $prop->id)
            ->assertRedirect();

        $this->assertDatabaseMissing('propiedades', ['id' => $prop->id]);
    }

    public function test_agente_cannot_delete_another_agents_property(): void
    {
        $otroUser = User::factory()->create([
            'rol_id' => Role::where('nombre', 'agente')->value('id'),
            'activo' => true,
        ]);
        $otroAgente = Agente::create([
            'usuario_id'        => $otroUser->id,
            'licencia_numero'   => 'LIC-003',
            'especialidad'      => 'Test',
            'anios_experiencia' => 1,
            'biografia'         => 'Test',
        ]);
        $propAjena = $this->crearPropiedad(['agente_id' => $otroAgente->id]);

        $this->actingAs($this->userAgente)
            ->delete('/agente/propiedades/' . $propAjena->id)
            ->assertStatus(403);

        $this->assertDatabaseHas('propiedades', ['id' => $propAjena->id]);
    }
}
