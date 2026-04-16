<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

Route::get('/', function () {
    return redirect('/login');
});

#Route::get('/', function () {
 #   return view('welcome');
#});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Productos: manager y admin
    Route::middleware('role:manager,admin')->group(function () {
        Route::resource('products', ProductController::class);
    });

    // Ventas: employee y admin
    Route::middleware('role:employee,admin')->group(function () {
        Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
        Route::post('/cart/add', [SaleController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/remove', [SaleController::class, 'removeFromCart'])->name('cart.remove');
        Route::post('/sales/confirm', [SaleController::class, 'confirmSale'])->name('sales.confirm');
        Route::get('/sales/{id}/ticket', [SaleController::class, 'ticket'])->name('sales.ticket');
    });

    // Historial: manager, owner, admin
    Route::middleware('role:manager,owner,admin')->group(function () {
        Route::get('/sales/history', [SaleController::class, 'history'])->name('sales.history');
    });

    // Reportes: manager, owner, admin
    Route::middleware('role:manager,owner,admin')->group(function () {
        Route::get('/reports/top-products', [SaleController::class, 'topProducts'])->name('reports.top');
        Route::get('/reports/daily', [SaleController::class, 'dailyReport'])->name('reports.daily');
    });

    Route::get('/dashboard', [SaleController::class, 'dashboard'])->name('dashboard');

    // Rutas para usuarios, solo para admin y owner
    Route::middleware('role:admin,owner')->group(function () {
        Route::resource('users', UserController::class);
    });
});

Route::get('/admin', function () {
    return "Panel Admin";
})->middleware('role:admin');

require __DIR__.'/auth.php';
