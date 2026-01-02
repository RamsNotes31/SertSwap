<?php

use App\Http\Controllers\LiquidityController;
use App\Http\Controllers\SwapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home redirects to swap
Route::get('/', function () {
    return redirect()->route('swap');
});

// Swap Interface
Route::get('/swap', [SwapController::class, 'index'])->name('swap');
Route::post('/swap/quote', [SwapController::class, 'getQuote'])->name('swap.quote');

// Liquidity Interface
Route::get('/liquidity', [LiquidityController::class, 'index'])->name('liquidity');
Route::post('/liquidity/pool', [LiquidityController::class, 'getPool'])->name('liquidity.pool');
Route::post('/liquidity/add-quote', [LiquidityController::class, 'getAddQuote'])->name('liquidity.add-quote');
