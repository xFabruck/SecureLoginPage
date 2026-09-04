<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
 
//Index
Route::get('/', function () {
    return view('index');
});
 
//Login view
Route::get('/login', function () {
    return view('Auth.login');
});
 
//Login
Route::middleware('guest')->group(function () {
 
    Route::get('/login', [LoginController::class, 'create'])
        ->name('login');
 
    Route::post('/login', [LoginController::class, 'store'])
        ->middleware('throttle:login')
        ->name('login.store');
 
        Route::get('/register',
            [LoginController::class, 'createRegister']
        )->name('register');
 
        Route::post('/register',
            [LoginController::class, 'register']
        )->name('register.store');
});
 
 
 
Route::middleware('auth')->group(function () {
 
    Route::get('/dashboard', function () {
        return view('dashboard.dashboard');
    })->name('dashboard');
 
    Route::post('/logout', [LoginController::class, 'destroy'])
        ->name('logout');
});
 
// ---------- API para la guía de seguridad (token con Sanctum) ----------
 
Route::post('/api/register', [LoginController::class, 'apiRegister']);
Route::post('/api/login', [LoginController::class, 'apiLogin']);
 
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/api/profile', [LoginController::class, 'apiProfile']);
    Route::post('/api/logout', [LoginController::class, 'apiLogout']);
});