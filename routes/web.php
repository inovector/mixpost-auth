<?php

use Illuminate\Support\Facades\Route;
use Inovector\MixpostAuth\Http\Controllers\AuthenticatedController;

Route::middleware(['web', 'guest'])->prefix('mixpost')->group(function () {
    Route::get('login', [AuthenticatedController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedController::class, 'store']);
});
