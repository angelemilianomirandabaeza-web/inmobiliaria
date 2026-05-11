<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed roles necesarios
        Role::insert([
            ['nombre' => 'admin'],
            ['nombre' => 'agente'],
            ['nombre' => 'cliente'],
            ['nombre' => 'agencia'],
        ]);
    }

    // ── REGISTRO ───────────────────────────────────────────────────────

    public function test_pagina_registro_carga_correctamente(): void
    {
        $this->get('/register')->assertStatus(200)->assertSee('Crear cuenta');
    }

    public function test_usuario_puede_registrarse(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Ana Prueba',
            'email'                 => 'ana@prueba.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['email' => 'ana@prueba.com']);
    }

    public function test_registro_asigna_rol_cliente(): void
    {
        $this->post('/register', [
            'name'                  => 'Cliente Nuevo',
            'email'                 => 'nuevo@cliente.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'nuevo@cliente.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->isCliente());
    }

    public function test_registro_falla_si_email_duplicado(): void
    {
        User::create([
            'name'     => 'Existente',
            'email'    => 'duplicado@correo.com',
            'password' => bcrypt('password'),
            'rol_id'   => Role::where('nombre', 'cliente')->value('id'),
            'activo'   => true,
        ]);

        $this->post('/register', [
            'name'                  => 'Nuevo',
            'email'                 => 'duplicado@correo.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('email');
    }

    public function test_registro_falla_sin_nombre(): void
    {
        $this->post('/register', [
            'name'                  => '',
            'email'                 => 'test@correo.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('name');
    }

    public function test_registro_falla_con_contrasena_corta(): void
    {
        $this->post('/register', [
            'name'                  => 'Test',
            'email'                 => 'test@correo.com',
            'password'              => '123',
            'password_confirmation' => '123',
        ])->assertSessionHasErrors('password');
    }

    public function test_registro_falla_con_contrasenas_distintas(): void
    {
        $this->post('/register', [
            'name'                  => 'Test',
            'email'                 => 'test@correo.com',
            'password'              => 'password123',
            'password_confirmation' => 'otrapassword',
        ])->assertSessionHasErrors('password');
    }

    // ── LOGIN ──────────────────────────────────────────────────────────

    public function test_pagina_login_carga_correctamente(): void
    {
        $this->get('/login')->assertStatus(200)->assertSee('Bienvenido de nuevo');
    }

    public function test_usuario_puede_hacer_login(): void
    {
        $rolId = Role::where('nombre', 'cliente')->value('id');
        $user  = User::create([
            'name'     => 'Login Test',
            'email'    => 'login@test.com',
            'password' => bcrypt('password123'),
            'rol_id'   => $rolId,
            'activo'   => true,
        ]);

        $this->post('/login', [
            'email'    => 'login@test.com',
            'password' => 'password123',
        ])->assertRedirect();

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_falla_con_contrasena_incorrecta(): void
    {
        $rolId = Role::where('nombre', 'cliente')->value('id');
        User::create([
            'name'     => 'Login Test',
            'email'    => 'login2@test.com',
            'password' => bcrypt('correcta'),
            'rol_id'   => $rolId,
            'activo'   => true,
        ]);

        $this->post('/login', [
            'email'    => 'login2@test.com',
            'password' => 'incorrecta',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_login_falla_con_email_inexistente(): void
    {
        $this->post('/login', [
            'email'    => 'noexiste@test.com',
            'password' => 'password123',
        ])->assertSessionHasErrors();

        $this->assertGuest();
    }

    public function test_usuario_autenticado_puede_hacer_logout(): void
    {
        $rolId = Role::where('nombre', 'cliente')->value('id');
        $user  = User::create([
            'name'     => 'Logout Test',
            'email'    => 'logout@test.com',
            'password' => bcrypt('password123'),
            'rol_id'   => $rolId,
            'activo'   => true,
        ]);

        $this->actingAs($user)
             ->post('/logout')
             ->assertRedirect();

        $this->assertGuest();
    }

    // ── REDIRECCIONES POR ROL ─────────────────────────────────────────

    public function test_admin_redirige_a_panel_admin(): void
    {
        $rolId = Role::where('nombre', 'admin')->value('id');
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@test.com',
            'password' => bcrypt('password'),
            'rol_id'   => $rolId,
            'activo'   => true,
        ]);

        $this->actingAs($admin)
             ->get('/dashboard')
             ->assertRedirect(route('admin.dashboard'));
    }

    public function test_cliente_no_puede_acceder_a_panel_admin(): void
    {
        $rolId   = Role::where('nombre', 'cliente')->value('id');
        $cliente = User::create([
            'name'     => 'Cliente',
            'email'    => 'cliente@test.com',
            'password' => bcrypt('password'),
            'rol_id'   => $rolId,
            'activo'   => true,
        ]);

        $this->actingAs($cliente)
             ->get('/admin/dashboard')
             ->assertStatus(403);
    }

    public function test_agente_no_puede_acceder_a_panel_admin(): void
    {
        $rolId  = Role::where('nombre', 'agente')->value('id');
        $agente = User::create([
            'name'     => 'Agente',
            'email'    => 'agente@test.com',
            'password' => bcrypt('password'),
            'rol_id'   => $rolId,
            'activo'   => true,
        ]);

        $this->actingAs($agente)
             ->get('/admin/dashboard')
             ->assertStatus(403);
    }

    public function test_invitado_redirige_a_login(): void
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
        $this->get('/cliente/dashboard')->assertRedirect('/login');
        $this->get('/agente/dashboard')->assertRedirect('/login');
    }
}
