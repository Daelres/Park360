<?php

use App\Http\Controllers\Admin\AtraccionController as AdminAtraccionController;
use App\Http\Controllers\Admin\SedeController as AdminSedeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/atracciones/{atraccion}', [PublicController::class, 'showAtraccion'])->name('public.atracciones.show');
Route::get('/planes', [PublicController::class, 'plans'])->name('public.plans');

Route::middleware('auth')->group(function () {
    Route::get('/pagos', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/pagos', [PaymentController::class, 'store'])->name('payments.store');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::redirect('/', '/admin/sedes');
    Route::resource('sedes', AdminSedeController::class);
    Route::resource('atracciones', AdminAtraccionController::class);
});

require __DIR__.'/auth.php';
