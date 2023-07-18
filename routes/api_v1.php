<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\SyncController;
use App\Http\Controllers\Api\v1\ApiAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Email and password authentication
Route::post('/email-login', [ApiAuthController::class, 'emailLogin'])->name('login.email');
// Generate mobile OTP
Route::post('/mobile-otp', [ApiAuthController::class, 'mobileOtp'])->name('mobile.otp');
// Verify mobile OTP and login
Route::post('/mobile-otp-verify', [ApiAuthController::class, 'mobileOtpVerify'])->name('mobile.otp.verify');

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Logout
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout');

    // Sync user data
    Route::post('/sync', [SyncController::class, 'sync'])->name('sync');
});