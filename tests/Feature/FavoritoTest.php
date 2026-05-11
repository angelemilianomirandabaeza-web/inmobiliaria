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

class FavoritoTest extends TestCase
{
    use RefreshDatabase;

    private User $cliente;
    private Propiedad $propiedad;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);

        $this->cliente = User::factory()->create([
            'rol_id' => Role::where('nombre', 'cliente')->value('id'),
            'activo' => true,
        ]);

        $agenteUser = User::factory()->create([
            'rol_id' => Role::where('nombre', 'agente')->value('id'),
            'activo' => true,
        ]);
        $agente = Agente::create([
            'usuario_id'        => $agenteUser->id,
            'licencia_numero'   => 'LIC-001',
            'especialidad'      => 'Test',
            'anios_experiencia' => 1,
            'biografia'         => 'Test',
        ]);

        $estado    = EstadoGeografico::create(['nombre' => 'CDMX', 'clave' => 'CDMX']);
        $municipio = Municipio::create(['nombre' => 'BJ', 'estado_id' => $estado->id]);
        $colonia   = Colonia::create(['nombre' => 'Del Valle', 'municipio_id' => $municipio->id]);

        $this->propiedad = Propiedad::create([
            'titulo'              => 'Casa Test',
            'descripcion'        => 'Test',
            'precio'             => 2000000,
            'tipo_operacion_id'  => TipoOperacion::create(['nombre' => 'Venta'])->id,
            'tipo_propiedad_id'  => TipoPropiedad::create(['nombre' => 'Casa'])->id,
            'estado_propiedad_id'=> EstadoPropiedad::create(['nombre' => 'Disponible', 'color' => '#10b981'])->id,
            'agente_id'          => $agente->id,
            'colonia_id'         => $colonia->id,
            'direccion'          => 'Calle 1',
            'aprobada'           => true,
        ]);
    }

    public function test_cliente_can_view_favoritos(): void
    {
        $this->actingAs($this->cliente)
            ->get('/cliente/favoritos')
            ->assertStatus(200);
    }

    public function test_guest_cannot_view_favoritos(): void
    {
        $this->get('/cliente/favoritos')->assertRedirect('/login');
    }

    public function test_cliente_can_add_favorito(): void
    {
        $this->actingAs($this->cliente)
            ->post('/cliente/favoritos/' . $this->propiedad->id)
            ->assertRedirect();

        $this->assertDatabaseHas('favoritos', [
            'cliente_id'   => $this->cliente->id,
            'propiedad_id' => $this->propiedad->id,
        ]);
    }

    public function test_cliente_can_remove_favorito(): void
    {
        // Agregar primero
        $this->actingAs($this->cliente)
            ->post('/cliente/favoritos/' . $this->propiedad->id);

        $this->assertDatabaseHas('favoritos', [
            'cliente_id'   => $this->cliente->id,
            'propiedad_id' => $this->propiedad->id,
        ]);

        // Eliminar
        $this->actingAs($this->cliente)
            ->delete('/cliente/favoritos/' . $this->propiedad->id)
            ->assertRedirect();

        $this->assertDatabaseMissing('favoritos', [
            'cliente_id'   => $this->cliente->id,
            'propiedad_id' => $this->propiedad->id,
        ]);
    }

    public function test_agente_cannot_add_favorito(): void
    {
        $agenteUser = User::factory()->create([
            'rol_id' => Role::where('nombre', 'agente')->value('id'),
            'activo' => true,
        ]);

        $this->actingAs($agenteUser)
            ->post('/cliente/favoritos/' . $this->propiedad->id)
            ->assertStatus(403);
    }
}
