<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// 1. Mobile App එකට ලොග් වෙන තැන
Route::post('/mobile-login', [GateController::class, 'mobileLogin']);

// 2. Mobile App එකෙන් ස්කෑන් කරද්දි එන තැන
Route::post('/mobile-scan', [GateController::class, 'mobileScan']);
Route::get('/mobile-scan-status/{cardNumber}', [GateController::class, 'checkMobileStatus']);