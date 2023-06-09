<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{id}', [ProductController::class, 'show']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    
        Route::get('/groups', [GroupController::class, 'index']);
        Route::get('/groups/{id}', [GroupController::class, 'show']);
        Route::post('/groups', [GroupController::class, 'store']);
        Route::delete('/groups/{id}', [GroupController::class, 'destroy']);
    
        Route::get('/stocks', [StockController::class, 'index']);
        Route::get('/stocks/{id}', [StockController::class, 'show']);
        Route::post('/stocks', [StockController::class, 'store']);
        Route::delete('/stocks/{id}', [StockController::class, 'destroy']);
    });

});