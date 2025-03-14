<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\BestSellers;

Route::middleware(['throttle:api'])->group(function (){
    Route::prefix('1')->group(function () {
        Route::prefix('best-sellers')->group(function () {
            Route::get('history', [BestSellers::class, 'history']);
        });
    });
});
