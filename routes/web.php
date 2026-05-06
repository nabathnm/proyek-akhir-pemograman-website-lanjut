<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KosController;
use App\Http\Controllers\KamarController;

Route::resource('kos', KosController::class);
Route::resource('kos.kamar', KamarController::class);
Route::get('/', function () {
    return view('welcome');
});
