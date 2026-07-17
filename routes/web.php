<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FixtureController;
use App\Http\Controllers\GameMatchController;
use App\Http\Controllers\MatchStatisticController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - KickMaster
|--------------------------------------------------------------------------
| Ei file e shob route define kora ache. Guest, auth, ar admin - tin vabe
| route gula ke group kora hoyeche.
*/

// Home route - shobar jonno accessible, fixtures dekhabe
Route::get('/', [FixtureController::class, 'home'])->name('home');

// ============== GUEST ROUTES (jara login kore nai) ==============
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ============== LOGOUT (auth thakle e kaj korbe) ==============
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ============== AUTH REQUIRED ROUTES (User + Admin) ==============
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Team dekha (view only for normal user)
    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
    Route::get('/players/{player}', [PlayerController::class, 'show'])->name('players.show');

    // Fixtures dekha
    Route::get('/fixtures', [FixtureController::class, 'index'])->name('fixtures.index');
    Route::get('/fixtures/{fixture}', [FixtureController::class, 'show'])->name('fixtures.show');

    // Match details ar live score dekha
    Route::get('/matches', [GameMatchController::class, 'index'])->name('matches.index');
    Route::get('/matches/{match}', [GameMatchController::class, 'show'])->name('matches.show');
});

// ============== ADMIN ONLY ROUTES ==============
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Team CRUD
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::get('/teams/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');
    Route::put('/teams/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::delete('/teams/{team}', [TeamController::class, 'destroy'])->name('teams.destroy');

    // Player CRUD
    Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
    Route::post('/players', [PlayerController::class, 'store'])->name('players.store');
    Route::get('/players/{player}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::put('/players/{player}', [PlayerController::class, 'update'])->name('players.update');
    Route::delete('/players/{player}', [PlayerController::class, 'destroy'])->name('players.destroy');

    // Fixture CRUD
    Route::get('/fixtures/create', [FixtureController::class, 'create'])->name('fixtures.create');
    Route::post('/fixtures', [FixtureController::class, 'store'])->name('fixtures.store');
    Route::get('/fixtures/{fixture}/edit', [FixtureController::class, 'edit'])->name('fixtures.edit');
    Route::put('/fixtures/{fixture}', [FixtureController::class, 'update'])->name('fixtures.update');
    Route::delete('/fixtures/{fixture}', [FixtureController::class, 'destroy'])->name('fixtures.destroy');

    // Match CRUD + score/stat update
    Route::get('/matches/create', [GameMatchController::class, 'create'])->name('matches.create');
    Route::post('/matches', [GameMatchController::class, 'store'])->name('matches.store');
    Route::get('/matches/{match}/edit', [GameMatchController::class, 'edit'])->name('matches.edit');
    Route::put('/matches/{match}', [GameMatchController::class, 'update'])->name('matches.update');
    Route::delete('/matches/{match}', [GameMatchController::class, 'destroy'])->name('matches.destroy');
    Route::post('/matches/{match}/score', [GameMatchController::class, 'updateScore'])->name('matches.updateScore');

    // Match statistics update
    Route::get('/matches/{match}/statistics', [MatchStatisticController::class, 'edit'])->name('matches.statistics.edit');
    Route::put('/matches/{match}/statistics', [MatchStatisticController::class, 'update'])->name('matches.statistics.update');
});