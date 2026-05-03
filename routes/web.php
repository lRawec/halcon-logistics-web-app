<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;

// Vistas públicas
Route::get('/', function (Illuminate\Http\Request $request) {
    $order = null;
    if ($request->has('customer_number') && $request->has('invoice_number')) {
        $order = App\Models\Order::where('customer_number', $request->customer_number)
            ->where('invoice_number', $request->invoice_number)
            ->with(['customer', 'photoEvidences'])
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

    // Dashboard - Accessible to all authenticated users
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        
        Route::get('/reports', function () {
            return view('admin.reports.index');
        })->name('reports.index');
    });

    // ========== SALES ROLE ROUTES ==========
    Route::middleware(['role:sales,admin'])->prefix('sales')->name('sales.')->group(function () {
        // Sales-specific dashboard can go here in the future
    });

    // ========== WAREHOUSE ROLE ROUTES ==========
    Route::middleware(['role:warehouse,admin'])->prefix('warehouse')->name('warehouse.')->group(function () {
        Route::get('/inventory', function () {
            return view('warehouse.inventory.index');
        })->name('inventory.index');
        
        Route::get('/pending-orders', function () {
            return view('warehouse.orders.pending');
        })->name('orders.pending');
    });

    // ========== ROUTE (DELIVERY) ROLE ROUTES ==========
    Route::middleware(['role:route,admin'])->prefix('delivery')->name('delivery.')->group(function () {
        Route::get('/active-orders', function () {
            return view('delivery.orders.active');
        })->name('orders.active');
        
        Route::get('/completed', function () {
            return view('delivery.orders.completed');
        })->name('orders.completed');
    });

    // ========== ORDERS MANAGEMENT (Sales + Admin) ==========
    Route::middleware(['role:sales,admin'])->group(function () {
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::get('/orders-archived', [OrderController::class, 'archived'])->name('orders.archived');
        Route::post('/orders/{id}/restore', [OrderController::class, 'restore'])->name('orders.restore');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit')->withTrashed();
    });

    // ========== CUSTOMER MANAGEMENT (Sales + Admin) ==========
    Route::middleware(['role:sales,admin'])->group(function () {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    });

    // ========== ORDERS VIEW & UPDATE (All authenticated users + role-based restrictions) ==========
    Route::middleware(['auth'])->group(function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show')->withTrashed();
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    });

    // Rutas para gestionar usuarios
    Route::resource('users', UserController::class);
});
