<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PosSessionController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {

    // User Profile
    Route::get('auth/user/profile', [UserController::class, 'profile'])->name('auth.user.profile');
    Route::get('auth/user/profile/edit', [UserController::class, 'editProfile'])->name('auth.user.profile.edit');
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Cashiers Management
    Route::get('cashiers', [CashierController::class, 'index'])->name('cashiers.index');
    Route::get('cashiers/create', [CashierController::class, 'create'])->name('cashiers.create');
    Route::post('cashiers', [CashierController::class, 'store'])->name('cashiers.store');
    Route::get('cashiers/{cashier}', [CashierController::class, 'show'])->name('cashiers.show');
    Route::get('cashiers/{cashier}/edit', [CashierController::class, 'edit'])->name('cashiers.edit');
    Route::put('cashiers/{cashier}', [CashierController::class, 'update'])->name('cashiers.update');
    Route::delete('cashiers/{cashier}', [CashierController::class, 'destroy'])->name('cashiers.destroy');

    // Meals Management
    Route::resource('meals', MealController::class);
    Route::post('meals/{meal}/toggle-availability', [MealController::class, 'toggleAvailability'])->name('meals.toggle-availability');

    // Orders Management
    Route::resource('orders', OrderController::class);
    Route::get('orders-api/meals', [OrderController::class, 'getMeals'])->name('orders.api.meals');

    // POS Interface (without sidebar)
    Route::get('pos', [OrderController::class, 'create'])->name('pos');

    // Invoices
    Route::get('invoices/{order}/print', [InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('invoices/{order}/kitchen-order', [InvoiceController::class, 'printKitchenOrder'])->name('invoices.kitchen-order');
    Route::get('invoices/{order}/delivery', [InvoiceController::class, 'printDelivery'])->name('invoices.delivery');

    // Reports
    Route::get('reports/daily', [ReportController::class, 'daily'])->name('reports.daily');

    // POS Sessions
    Route::post('pos-sessions/open', [PosSessionController::class, 'open'])->name('pos-sessions.open');
    Route::post('pos-sessions/close', [PosSessionController::class, 'close'])->name('pos-sessions.close');
    Route::get('pos-sessions/status', [PosSessionController::class, 'status'])->name('pos-sessions.status');
});
