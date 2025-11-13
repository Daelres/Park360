<?php

use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AtraccionController as AdminAtraccionController;
use App\Http\Controllers\Admin\SedeController as AdminSedeController;
use App\Http\Controllers\Admin\AnaliticaController as AdminAnaliticaController;
use App\Http\Controllers\Admin\ReporteController as AdminReporteController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Payments\TestCheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\VisitCheckInController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/atracciones/{atraccion}', [PublicController::class, 'showAtraccion'])->name('public.atracciones.show');
Route::get('/planes', [PublicController::class, 'plans'])->name('public.plans');

Route::middleware('auth')->group(function () {

    Route::get('/pagos', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/pagos/visit-dates', [PaymentController::class, 'storeVisitDate'])->name('payments.visit-dates.store');

    Route::post('/checkout/session', [CheckoutController::class, 'store'])->name('checkout.session.store');
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::get('/checkout/success/{order:uuid}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');

    Route::get('/visitas/scan', [VisitCheckInController::class, 'create'])->name('visit-scan.create');
    Route::post('/visitas/scan', [VisitCheckInController::class, 'store'])->name('visit-scan.store');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified', 'role:admin|employee'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('pagos/prueba')->name('payments.test.')->group(function () {
        Route::get('/', [TestCheckoutController::class, 'show'])->name('show');
        Route::post('/session', [TestCheckoutController::class, 'createSession'])->name('session');
        Route::get('/retorno', [TestCheckoutController::class, 'handleReturn'])->name('return');
    });
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::redirect('/', '/admin/sedes');
    Route::get('/users/myProfile', [AdminUsersController::class, 'index'])->name('myProfile');
    // Gestión de usuarios, roles y permisos
    Route::get('/usuarios', [AdminUsersController::class, 'manage'])->name('users.index');
    Route::post('/usuarios/{user}/roles', [AdminUsersController::class, 'assignRole'])
        ->name('users.roles.assign');
    Route::post('/roles', [AdminUsersController::class, 'storeRole'])->name('roles.store');
    Route::resource('sedes', AdminSedeController::class);
    Route::resource('atracciones', AdminAtraccionController::class);
    // Analítica de aplicación (solo administradores)
    Route::get('analitica', [AdminAnaliticaController::class, 'index'])->name('analitica.index');
});

// Reportes: accesible para cualquier usuario autenticado (no requiere rol admin)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('reportes', AdminReporteController::class)->parameters(['reportes' => 'reporte']);
});

require __DIR__.'/auth.php';
