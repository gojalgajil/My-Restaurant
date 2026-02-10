<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\OrderController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Public table routes (for guests to see available tables)
Route::get('/tables', [TableController::class, 'index']);
Route::get('/tables/available', [TableController::class, 'getAvailableTables']);
Route::get('/tables/{id}', [TableController::class, 'show']);

// Public food routes
Route::get('/foods', [FoodController::class, 'index']);
Route::get('/foods/{id}', [FoodController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Food management (CRUD)
    Route::apiResource('foods', FoodController::class)->except(['index', 'show']);

    // Table management
    Route::apiResource('tables', TableController::class)->except(['index', 'show']);

    // Order management
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);
    Route::post('/orders/{id}/items', [OrderController::class, 'addItem']);
    Route::delete('/orders/{id}/items/{itemId}', [OrderController::class, 'removeItem']);
    Route::post('/orders/{id}/close', [OrderController::class, 'closeOrder']);
    Route::post('/orders/{id}/paid', [OrderController::class, 'markAsPaid']);
    Route::get('/orders/{id}/receipt', [OrderController::class, 'getReceiptHTML']);
    Route::get('/orders/{id}/receipt/pdf', [OrderController::class, 'generateReceipt']);
});
