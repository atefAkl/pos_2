<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TerminalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PosSessionController;
use App\Http\Controllers\ShiftController;

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

    // Terminals Management
    Route::get('terminals', [TerminalController::class, 'index'])->name('terminals.index');
    Route::post('terminals', [TerminalController::class, 'store'])->name('terminals.store');
    Route::get('terminals/{terminal}', [TerminalController::class, 'show'])->name('terminals.show');
    Route::put('terminals/{terminal}', [TerminalController::class, 'update'])->name('terminals.update');
    Route::delete('terminals/{terminal}', [TerminalController::class, 'destroy'])->name('terminals.destroy');

    // Shifts Management

    Route::get('shifts', [ShiftController::class, 'index'])->name('shifts.index');
    Route::post('shifts/store', [ShiftController::class, 'store'])->name('shifts.store');
    Route::delete('shifts/{shift}/destroy', [ShiftController::class, 'destroy'])->name('shifts.destroy');
    Route::delete('shifts/{shift}/end', [ShiftController::class, 'end'])->name('shifts.end');

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

    // Staff
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::get('/cashiers', [CashierController::class, 'index'])->name('cahiers.index');
        Route::post('/cashiers/store', [CashierController::class, 'store'])->name('cashiers.store');
        Route::get('/cashiers/{cashier}/edit', [CashierController::class, 'store'])->name('cashiers.edit');
        Route::get('/cashiers/{cashier}/profile', [CashierController::class, 'store'])->name('cashiers.profile');
    });
});
