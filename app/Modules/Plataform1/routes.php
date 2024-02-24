<?php

use App\Modules\Plataform1\Http\Controllers\ProductController;
use App\Modules\Plataform1\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

Route::prefix('plataform1/api/v1')->middleware([EnsureTokenIsValid::class])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
});
