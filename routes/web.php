<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
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

// Home route - shobar jonno accessible
Route::view('/', 'welcome')->name('home');

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
});