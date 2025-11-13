<?php

use App\Http\Controllers\AttractionController;
use App\Http\Controllers\CheckInController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IncidentController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TicketTypeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('employees', EmployeeController::class);
    Route::resource('attractions', AttractionController::class);
    Route::resource('tasks', TaskController::class)->except('show');
    Route::resource('incidents', IncidentController::class)->except('show');
    Route::resource('maintenances', MaintenanceController::class)->except('show');
    Route::resource('ticket-types', TicketTypeController::class)->except('show');

    Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'show']);
    Route::get('orders/{order}/tickets/{ticket}/pdf', [OrderController::class, 'downloadTicketPdf'])->name('orders.tickets.pdf');
    Route::get('orders/{order}/tickets/{ticket}/qr', [OrderController::class, 'downloadTicketQr'])->name('orders.tickets.qr');

    Route::get('check-in', [CheckInController::class, 'create'])->name('check-in.create');
    Route::post('check-in', [CheckInController::class, 'store'])->name('check-in.store');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/sales', [ReportController::class, 'exportSales'])->name('reports.sales');
    Route::get('reports/attractions', [ReportController::class, 'exportAttractions'])->name('reports.attractions');
});
