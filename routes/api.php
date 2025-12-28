<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\ShopController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Super Admin API Routes
Route::middleware(['auth:sanctum', \App\Http\Middleware\SuperAdminMiddleware::class])
    ->prefix('super-admin')
    ->group(function () {
        Route::apiResource('shops', ShopController::class);
        Route::patch('shops/{shop}/toggle-status', [ShopController::class, 'toggleStatus']);
    });

// Authenticated API Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('loans', LoanController::class);
    Route::apiResource('payments', PaymentController::class)->except(['update']);
});
