<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('customers.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Customer routes
    Route::resource('customers', \App\Http\Controllers\CustomerController::class);
    
    // Loan routes
    Route::resource('loans', \App\Http\Controllers\LoanController::class);
    Route::get('loans/{loan}/pawn-ticket', [\App\Http\Controllers\LoanController::class, 'generatePawnTicket'])
        ->name('loans.pawn-ticket');
    
    // Payment routes
    Route::resource('payments', \App\Http\Controllers\PaymentController::class)
        ->except(['edit', 'update']);
    Route::get('payments/{payment}/receipt', [\App\Http\Controllers\PaymentController::class, 'generateReceipt'])
        ->name('payments.receipt');
});

require __DIR__.'/auth.php';
