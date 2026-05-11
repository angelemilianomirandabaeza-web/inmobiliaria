<?php

namespace Tests\Feature;

use App\Models\Agente;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    private function makeUser(string $rolNombre): User
    {
        return User::factory()->create([
            'rol_id' => Role::where('nombre', $rolNombre)->value('id'),
            'activo' => true,
        ]);
    }

    private function makeAgente(): array
    {
        $user = $this->makeUser('agente');
        $agente = Agente::create([
            'usuario_id'        => $user->id,
            'licencia_numero'   => 'LIC-TEST',
            'especialidad'      => 'Test',
            'anios_experiencia' => 1,
            'biografia'         => 'Test',
        ]);
        return [$user, $agente];
    }

    // ── PANEL CLIENTE ──────────────────────────────────────────────

    public function test_guest_cannot_access_cliente_dashboard(): void
    {
        $this->get('/cliente/dashboard')->assertRedirect('/login');
    }

    public function test_cliente_can_access_cliente_dashboard(): void
    {
        $user = $this->makeUser('cliente');
        $this->actingAs($user)->get('/cliente/dashboard')->assertStatus(200);
    }

    public function test_agente_cannot_access_cliente_dashboard(): void
    {
        [$user] = $this->makeAgente();
        $this->actingAs($user)->get('/cliente/dashboard')->assertStatus(403);
    }

    public function test_admin_cannot_access_cliente_dashboard(): void
    {
        $user = $this->makeUser('admin');
        $this->actingAs($user)->get('/cliente/dashboard')->assertStatus(403);
    }

    // ── PANEL AGENTE ───────────────────────────────────────────────

    public function test_guest_cannot_access_agente_dashboard(): void
    {
        $this->get('/agente/dashboard')->assertRedirect('/login');
    }

    public function test_agente_can_access_agente_dashboard(): void
    {
        [$user] = $this->makeAgente();
        $this->actingAs($user)->get('/agente/dashboard')->assertStatus(200);
    }

    public function test_cliente_cannot_access_agente_panel(): void
    {
        $user = $this->makeUser('cliente');
        $this->actingAs($user)->get('/agente/dashboard')->assertStatus(403);
    }

    // ── PANEL ADMIN ────────────────────────────────────────────────

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $user = $this->makeUser('admin');
        $this->actingAs($user)->get('/admin/dashboard')->assertStatus(200);
    }

    public function test_cliente_cannot_access_admin_dashboard(): void
    {
        $user = $this->makeUser('cliente');
        $this->actingAs($user)->get('/admin/dashboard')->assertStatus(403);
    }

    public function test_agente_cannot_access_admin_dashboard(): void
    {
        [$user] = $this->makeAgente();
        $this->actingAs($user)->get('/admin/dashboard')->assertStatus(403);
    }

    // ── DASHBOARD REDIRECT ─────────────────────────────────────────

    public function test_dashboard_redirects_admin_to_admin_panel(): void
    {
        $user = $this->makeUser('admin');
        $this->actingAs($user)->get('/dashboard')->assertRedirect('/admin/dashboard');
    }

    public function test_dashboard_redirects_agente_to_agente_panel(): void
    {
        [$user] = $this->makeAgente();
        $this->actingAs($user)->get('/dashboard')->assertRedirect('/agente/dashboard');
    }

    public function test_dashboard_redirects_cliente_to_cliente_panel(): void
    {
        $user = $this->makeUser('cliente');
        $this->actingAs($user)->get('/dashboard')->assertRedirect('/cliente/dashboard');
    }
}
