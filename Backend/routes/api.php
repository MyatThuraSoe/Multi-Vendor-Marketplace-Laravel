<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SellerRegistrationController;
use App\Http\Controllers\Buyer\CheckoutController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\WithdrawalController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\WithdrawalController as AdminWithdrawalController;
use App\Http\Controllers\Buyer\ReviewController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
Route::post('/seller/register', [SellerRegistrationController::class, 'register']);

// Buyer
Route::middleware(['auth:sanctum', 'role:buyer'])->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'checkout']);
    Route::post('/reviews', [ReviewController::class, 'store']);
});

// Seller
Route::middleware(['auth:sanctum', 'role:seller'])->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::post('/withdrawals', [WithdrawalController::class, 'request']);
});

// Admin
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::put('/users/{user}', [UserManagementController::class, 'update']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::put('/withdrawals/{withdrawal}', [AdminWithdrawalController::class, 'handleAction']);
});
