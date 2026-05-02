<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Api\AutocompleteController;
use App\Http\Controllers\Admin\PropiedadAprobacionController;
use App\Http\Controllers\Agente\AgenteDashboardController;
use App\Http\Controllers\Agente\PropiedadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cliente\ClienteDashboardController;
use App\Http\Controllers\Cliente\FavoritoController;
use App\Http\Controllers\Public\BusquedaController;
use App\Http\Controllers\Public\ComparadorController;
use App\Http\Controllers\Public\ContactoController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PropiedadPublicaController;
use Illuminate\Support\Facades\Route;

// ── PUBLICAS ─────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/propiedades', [BusquedaController::class, 'index'])->name('propiedades.buscar');
Route::get('/propiedades/{propiedad}', [PropiedadPublicaController::class, 'show'])->name('propiedades.show');
Route::get('/comparar', [ComparadorController::class, 'index'])->name('comparar');
Route::post('/contacto/{propiedad}', [ContactoController::class, 'store'])->name('contacto.store');
Route::get('/api/autocomplete', [AutocompleteController::class, 'search'])->name('api.autocomplete');

// ── AUTH ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ── DASHBOARD ────────────────────────────────────────
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin())   return redirect()->route('admin.dashboard');
    if ($user->isAgente())  return redirect()->route('agente.dashboard');
    return redirect()->route('cliente.dashboard');
})->middleware('auth')->name('dashboard');

// ── PANEL CLIENTE ────────────────────────────────────
Route::middleware(['auth', 'role:cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    Route::get('/dashboard', [ClienteDashboardController::class, 'index'])->name('dashboard');
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
    Route::post('/favoritos/{propiedad}', [FavoritoController::class, 'store'])->name('favoritos.store');
    Route::delete('/favoritos/{propiedad}', [FavoritoController::class, 'destroy'])->name('favoritos.destroy');
});

// ── PANEL AGENTE ─────────────────────────────────────
Route::middleware(['auth', 'role:agente'])->prefix('agente')->name('agente.')->group(function () {
    Route::get('/dashboard', [AgenteDashboardController::class, 'index'])->name('dashboard');
    Route::resource('propiedades', PropiedadController::class);
});

// ── PANEL ADMIN ──────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/propiedades', [PropiedadAprobacionController::class, 'index'])->name('propiedades.index');
    Route::patch('/propiedades/{propiedad}/aprobar', [PropiedadAprobacionController::class, 'aprobar'])->name('propiedades.aprobar');
    Route::delete('/propiedades/{propiedad}/rechazar', [PropiedadAprobacionController::class, 'rechazar'])->name('propiedades.rechazar');
});
