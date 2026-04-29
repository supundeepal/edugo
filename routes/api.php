<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Mobile App API Routes
Route::post('/mobile-login', [GateController::class, 'mobileLogin']);
Route::post('/mobile-scan', [GateController::class, 'mobileScan']);

// 💥 මෙන්න මේකයි අඩුවෙලා තිබ්බේ! ෆෝන් එකෙන් තත්පරෙන් තත්පරේට "මාර්ක් කරාද" අහන Route එක!
Route::get('/mobile-status/{cardNumber}', [GateController::class, 'checkMobileStatus']);