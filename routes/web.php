<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

// Rutas 2FA Desafío (Sin requerir estar autenticado aún)
Route::get('/2fa/challenge', [TwoFactorController::class, 'showChallenge'])->name('2fa.challenge');
Route::post('/2fa/challenge', [TwoFactorController::class, 'verifyChallenge'])->name('2fa.challenge.verify');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [SaleController::class, 'dashboard'])->name('dashboard');

    // Configuración 2FA
    Route::get('/2fa/setup', [TwoFactorController::class, 'showEnableForm'])->name('2fa.setup');
    Route::post('/2fa/enable', [TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('/2fa/disable', [TwoFactorController::class, 'disable'])->name('2fa.disable');

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

    // Rutas para usuarios, solo para admin y owner
    Route::middleware('role:admin,owner')->group(function () {
        Route::resource('users', UserController::class);
    });
});

Route::get('/admin', function () {
    return "Panel Admin";
})->middleware(['auth', 'role:admin']);

require __DIR__.'/auth.php';
