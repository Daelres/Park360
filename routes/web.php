<?php

use App\Http\Controllers\Admin\AtraccionController as AdminAtraccionController;
use App\Http\Controllers\Admin\SedeController as AdminSedeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('public.home');
Route::get('/atracciones/{atraccion}', [PublicController::class, 'showAtraccion'])->name('public.atracciones.show');
Route::get('/planes', [PublicController::class, 'plans'])->name('public.plans');

Route::get('/pagos', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/pagos', [PaymentController::class, 'store'])->name('payments.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::redirect('/', '/admin/sedes');
    Route::resource('sedes', AdminSedeController::class);
    Route::resource('atracciones', AdminAtraccionController::class);
});
