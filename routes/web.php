<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperDashboard;
use App\Http\Controllers\SuperAdmin\ShopController;
use App\Http\Middleware\SuperAdminMiddleware;
use App\Http\Middleware\ShopPermissionMiddleware;
use App\Http\Middleware\ShopAdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'super_admin') {
        return redirect()->route('super-admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Super Admin Routes
Route::middleware(['auth', 'verified', SuperAdminMiddleware::class])
    ->prefix('super-admin')
    ->name('super-admin.')
    ->group(function () {
        Route::get('/dashboard', [SuperDashboard::class, 'index'])->name('dashboard');
        Route::resource('shops', ShopController::class);
        Route::patch('shops/{shop}/toggle-status', [ShopController::class, 'toggleStatus'])->name('shops.toggle-status');
    });

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Shop Context Routes
    Route::middleware([ShopPermissionMiddleware::class])->group(function() {
        // Customer routes
        Route::resource('customers', \App\Http\Controllers\CustomerController::class);
        
        // Loan routes
        Route::resource('loans', \App\Http\Controllers\LoanController::class);
        Route::get('loans/{loan}/ticket', [\App\Http\Controllers\LoanController::class, 'ticket'])
            ->name('loans.ticket');
        Route::get('loans/{loan}/pawn-ticket', [\App\Http\Controllers\LoanController::class, 'generatePawnTicket'])
            ->name('loans.pawn-ticket');
        
        // Payment routes
        Route::resource('payments', \App\Http\Controllers\PaymentController::class)
            ->except(['edit', 'update']);
        Route::get('payments/{payment}/receipt', [\App\Http\Controllers\PaymentController::class, 'generateReceipt'])
            ->name('payments.receipt');
        
        // User management for Shop Admins
        Route::middleware([ShopAdminMiddleware::class])->group(function() {
            Route::resource('users', \App\Http\Controllers\ShopAdmin\UserController::class);
        });
    });
});

require __DIR__.'/auth.php';
