<?php

use App\Http\Controllers\Api\TokenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {
    // Chain information
    Route::get('/chains', [TokenController::class, 'chains']);

    // Token endpoints
    Route::get('/tokens', [TokenController::class, 'index']);
    Route::get('/tokens/{address}', [TokenController::class, 'show']);

    // Transaction endpoints
    Route::get('/transactions', [TokenController::class, 'transactions']);
    Route::post('/transactions', [TokenController::class, 'storeTransaction']);
});
