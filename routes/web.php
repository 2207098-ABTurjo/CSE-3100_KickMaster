<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
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
});