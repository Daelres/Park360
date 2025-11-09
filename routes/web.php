<?php

use App\Http\Controllers\Admin\AtraccionController as AdminAtraccionController;
use App\Http\Controllers\Admin\SedeController as AdminSedeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/atracciones/{atraccion}', [PublicController::class, 'showAtraccion'])->name('public.atracciones.show');
Route::get('/planes', [PublicController::class, 'plans'])->name('public.plans');

Route::get('/pagos', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/pagos', [PaymentController::class, 'store'])->name('payments.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/sedes');
    Route::resource('sedes', AdminSedeController::class);
    Route::resource('atracciones', AdminAtraccionController::class);
});
