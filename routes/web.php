<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

// Vistas públicas
Route::get('/', function (Illuminate\Http\Request $request) {
    $order = null;
    if ($request->has('invoice')) {
        $order = App\Models\Order::where('invoice_number', $request->invoice)
            ->with('photoEvidences')
            ->first();
    }
    return view('welcome', compact('order'));
})->name('home');

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas para gestionar usuarios y órdenes
    Route::resource('users', UserController::class);
    Route::resource('orders', OrderController::class);

    // Ruta para restaurar órdenes
    Route::post('/orders/{id}/restore', [OrderController::class, 'restore'])->name('orders.restore');

    // Ruta especial para ver las órdenes archivadas (borrado lógico)
    Route::get('/orders-archived', [OrderController::class, 'archived'])->name('orders.archived');
});
