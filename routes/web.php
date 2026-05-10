<?php

use App\Http\Controllers\Admin\AdminAgenteController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Api\AutocompleteController;
use App\Http\Controllers\Api\QuickViewController;
use App\Http\Controllers\Admin\PropiedadAprobacionController;
use App\Http\Controllers\Agente\AgenteDashboardController;
use App\Http\Controllers\Agente\PipelineController;
use App\Http\Controllers\Agente\PropiedadController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cliente\ClienteDashboardController;
use App\Http\Controllers\Cliente\FavoritoController;
use App\Http\Controllers\Cliente\VisitaController as ClienteVisitaController;
use App\Http\Controllers\Cliente\AlertaController;
use App\Http\Controllers\Cliente\ResenaController;
use App\Http\Controllers\Public\BusquedaController;
use App\Http\Controllers\Public\BusquedaExteriorController;
use App\Http\Controllers\Public\ComparadorController;
use App\Http\Controllers\Public\ContactoController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PropiedadPublicaController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// ── PUBLICAS ─────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/propiedades', [BusquedaController::class, 'index'])->name('propiedades.buscar');
Route::get('/propiedades/{propiedad}', [PropiedadPublicaController::class, 'show'])->name('propiedades.show');
Route::get('/comparar', [ComparadorController::class, 'index'])->name('comparar');
Route::post('/contacto/{propiedad}', [ContactoController::class, 'store'])->middleware('throttle:5,1')->name('contacto.store');
Route::get('/busqueda-exterior', [BusquedaExteriorController::class, 'index'])->name('busqueda.exterior');
Route::get('/api/autocomplete', [AutocompleteController::class, 'search'])->middleware('throttle:60,1')->name('api.autocomplete');
Route::get('/api/quick-view/{propiedad}', [QuickViewController::class, 'show'])->middleware('throttle:60,1')->name('api.quick-view');
Route::get('/api/mapa-propiedades', [QuickViewController::class, 'mapData'])->middleware('throttle:30,1')->name('api.mapa-propiedades');

// SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/robots.txt', [SitemapController::class, 'robots']);

// ── AUTH ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/perfil', [AuthController::class, 'editProfile'])->name('profile.edit');
    Route::patch('/perfil', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::patch('/perfil/password', [AuthController::class, 'updatePassword'])->name('profile.password');
});

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

    Route::get('/visitas', [ClienteVisitaController::class, 'index'])->name('visitas.index');
    Route::post('/visitas/{propiedad}', [ClienteVisitaController::class, 'store'])->name('visitas.store');
    Route::delete('/visitas/{visita}', [ClienteVisitaController::class, 'destroy'])->name('visitas.destroy');

    Route::resource('/alertas', AlertaController::class)->only(['index', 'store', 'destroy']);

    Route::post('/resenas/{agente}', [ResenaController::class, 'store'])->name('resenas.store');
});

// ── PANEL AGENTE ─────────────────────────────────────
Route::middleware(['auth', 'role:agente'])->prefix('agente')->name('agente.')->group(function () {
    Route::get('/dashboard', [AgenteDashboardController::class, 'index'])->name('dashboard');
    Route::resource('propiedades', PropiedadController::class)->parameters([
        'propiedades' => 'propiedad'
    ]);
    Route::get('/pipeline', [PipelineController::class, 'index'])->name('pipeline.index');
    Route::post('/pipeline', [PipelineController::class, 'store'])->name('pipeline.store');
    Route::patch('/pipeline/{pipeline}/etapa', [PipelineController::class, 'updateEtapa'])->name('pipeline.update-etapa');
    Route::delete('/pipeline/{pipeline}', [PipelineController::class, 'destroy'])->name('pipeline.destroy');
    Route::patch('/visitas/{visita}/estado', [\App\Http\Controllers\Agente\VisitaController::class, 'updateEstado'])->name('visitas.update-estado');
});

// ── PANEL ADMIN ──────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/reporte', [AdminDashboardController::class, 'reporte'])->name('reporte');
    Route::get('/propiedades', [PropiedadAprobacionController::class, 'index'])->name('propiedades.index');
    Route::patch('/propiedades/{propiedad}/aprobar', [PropiedadAprobacionController::class, 'aprobar'])->name('propiedades.aprobar');
    Route::delete('/propiedades/{propiedad}/rechazar', [PropiedadAprobacionController::class, 'rechazar'])->name('propiedades.rechazar');
    Route::delete('/propiedades/{propiedad}', [PropiedadAprobacionController::class, 'destroy'])->name('propiedades.destroy');

    // Gestión de agentes
    Route::resource('agentes', AdminAgenteController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::patch('/agentes/{agente}/toggle-activo', [AdminAgenteController::class, 'toggleActivo'])->name('agentes.toggle-activo');
});
