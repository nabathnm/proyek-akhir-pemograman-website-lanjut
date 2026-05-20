<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KosanApiController;
use App\Http\Controllers\Api\PemesananApiController;
use App\Http\Controllers\Api\UlasanApiController;

// =====================
// PUBLIC ROUTES
// =====================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Public: daftar & detail kosan
Route::get('/kosan', [KosanApiController::class, 'index']);
Route::get('/kosan/{id}', [KosanApiController::class, 'show']);

// Public: daftar ulasan per kosan
Route::get('/kosan/{id}/ulasan', [UlasanApiController::class, 'index']);

// =====================
// PROTECTED ROUTES (JWT)
// =====================
Route::middleware('auth:api')->group(function () {

    // --- Auth ---
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);

    // --- Kosan (hanya pemilik) ---
    Route::get('/my-kosan', [KosanApiController::class, 'myKosan']);
    Route::post('/kosan', [KosanApiController::class, 'store']);
    Route::put('/kosan/{id}', [KosanApiController::class, 'update']);
    Route::patch('/kosan/{id}', [KosanApiController::class, 'update']);
    Route::delete('/kosan/{id}', [KosanApiController::class, 'destroy']);

    // --- Pemesanan ---
    Route::get('/pemesanan', [PemesananApiController::class, 'index']);
    Route::post('/pemesanan', [PemesananApiController::class, 'store']);
    Route::get('/pemesanan/{id}', [PemesananApiController::class, 'show']);
    Route::patch('/pemesanan/{id}/status', [PemesananApiController::class, 'updateStatus']);
    Route::delete('/pemesanan/{id}', [PemesananApiController::class, 'destroy']);

    // --- Ulasan ---
    Route::post('/kosan/{id}/ulasan', [UlasanApiController::class, 'store']);
    Route::delete('/ulasan/{id}', [UlasanApiController::class, 'destroy']);
});