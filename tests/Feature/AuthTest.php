<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RoleSeeder::class);
    }

    private function clienteRolId(): int
    {
        return Role::where('nombre', 'cliente')->value('id');
    }

    // ── LOGIN ──────────────────────────────────────────────────────

    public function test_login_page_is_accessible(): void
    {
        $this->get('/login')->assertStatus(200);
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'rol_id'   => $this->clienteRolId(),
            'activo'   => true,
        ]);

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_wrong_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'rol_id'   => $this->clienteRolId(),
            'activo'   => true,
        ]);

        $this->post('/login', ['email' => $user->email, 'password' => 'wrong'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
            'rol_id'   => $this->clienteRolId(),
            'activo'   => false,
        ]);

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_requires_email_and_password(): void
    {
        $this->post('/login', [])
            ->assertSessionHasErrors(['email', 'password']);
    }

    // ── LOGOUT ─────────────────────────────────────────────────────

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create([
            'rol_id' => $this->clienteRolId(),
            'activo' => true,
        ]);

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }

    // ── REGISTER ───────────────────────────────────────────────────

    public function test_register_page_is_accessible(): void
    {
        $this->get('/register')->assertStatus(200);
    }

    public function test_new_user_can_register(): void
    {
        $this->post('/register', [
            'name'                  => 'Nuevo Usuario',
            'email'                 => 'nuevo@test.com',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
            'telefono'              => '5512345678',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email'  => 'nuevo@test.com',
            'rol_id' => $this->clienteRolId(),
            'activo' => true,
        ]);
    }

    public function test_register_requires_unique_email(): void
    {
        User::factory()->create([
            'email'  => 'existe@test.com',
            'rol_id' => $this->clienteRolId(),
            'activo' => true,
        ]);

        $this->post('/register', [
            'name'                  => 'Otro Usuario',
            'email'                 => 'existe@test.com',
            'password'              => 'Password123!',
            'password_confirmation' => 'Password123!',
        ])->assertSessionHasErrors('email');
    }

    public function test_register_requires_password_confirmation(): void
    {
        $this->post('/register', [
            'name'                  => 'Test',
            'email'                 => 'test@test.com',
            'password'              => 'Password123!',
            'password_confirmation' => 'DifferentPassword!',
        ])->assertSessionHasErrors('password');
    }

    // ── PERFIL ─────────────────────────────────────────────────────

    public function test_profile_page_requires_auth(): void
    {
        $this->get('/perfil')->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_profile(): void
    {
        $user = User::factory()->create([
            'rol_id' => $this->clienteRolId(),
            'activo' => true,
        ]);

        $this->actingAs($user)->get('/perfil')->assertStatus(200);
    }

    public function test_user_can_update_profile(): void
    {
        $user = User::factory()->create([
            'rol_id' => $this->clienteRolId(),
            'activo' => true,
        ]);

        $this->actingAs($user)
            ->patch('/perfil', [
                'name'     => 'Nombre Actualizado',
                'email'    => $user->email,
                'telefono' => '5599887766',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id'   => $user->id,
            'name' => 'Nombre Actualizado',
        ]);
    }

    public function test_user_can_update_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('OldPassword1!'),
            'rol_id'   => $this->clienteRolId(),
            'activo'   => true,
        ]);

        $this->actingAs($user)
            ->patch('/perfil/password', [
                'current_password'      => 'OldPassword1!',
                'password'              => 'NewPassword1!',
                'password_confirmation' => 'NewPassword1!',
            ])
            ->assertRedirect();

        $user->refresh();
        $this->assertTrue(Hash::check('NewPassword1!', $user->password));
    }

    public function test_update_password_rejects_wrong_current_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('OldPassword1!'),
            'rol_id'   => $this->clienteRolId(),
            'activo'   => true,
        ]);

        $this->actingAs($user)
            ->patch('/perfil/password', [
                'current_password'      => 'WrongPassword!',
                'password'              => 'NewPassword1!',
                'password_confirmation' => 'NewPassword1!',
            ])
            ->assertSessionHasErrors('current_password');
    }

    // ── GUEST REDIRECTS ────────────────────────────────────────────

    public function test_authenticated_user_is_redirected_from_login(): void
    {
        $user = User::factory()->create([
            'rol_id' => $this->clienteRolId(),
            'activo' => true,
        ]);

        $this->actingAs($user)->get('/login')->assertRedirect();
    }
}
