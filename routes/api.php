<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::middleware(['auth:api', 'role:pemilik'])->prefix('pemilik')->group(function () {
    // API endpoints for Pemilik (Kosans, Bookings, etc)
});

Route::middleware(['auth:api', 'role:user'])->prefix('user')->group(function () {
    // API endpoints for User
});
