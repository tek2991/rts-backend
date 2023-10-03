<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\SyncController;
use App\Http\Controllers\Api\v1\ApiAuthController;
use App\Http\Controllers\Api\v1\CallLogSyncController;
use App\Http\Controllers\Api\v1\ContactSyncController;
use App\Http\Controllers\Api\v1\MessageSyncController;
use App\Http\Controllers\Api\v1\UploadPhotoController;
use App\Http\Controllers\Api\v1\UploadVideoController;
use App\Http\Controllers\Api\v1\UpdateLocationController;
use App\Http\Controllers\Api\v1\UploadRecordingController;
use App\Http\Controllers\Api\v1\UploadScreenRecordingController;
use App\Http\Controllers\Api\v1\CheckApkVersionController;

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

// Dealers
// Route::get('/dealers', [App\Http\Controllers\Api\v1\DealerController::class, 'index'])->name('dealers');
// Route::post('/dealer/submit', [App\Http\Controllers\Api\v1\DealerController::class, 'submit'])->name('dealer.submit');

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Logout
    Route::post('/logout', [ApiAuthController::class, 'logout'])->name('mobile.logout');

    // Sync user data
    Route::post('/sync', [SyncController::class, 'sync'])->name('sync');

    // Sync device status
    Route::post('/device-status', [SyncController::class, 'deviceStatus'])->name('device.status');

    // Get last message
    Route::post('/last-message', [MessageSyncController::class, 'getLastMessage'])->name('last.message');

    // Upload message
    Route::post('/upload-message', [MessageSyncController::class, 'uploadMessages'])->name('upload.message');

    // Update location
    Route::post('/update-location', [UpdateLocationController::class, 'updateLocation'])->name('update.location');

    // Upload Photo
    Route::post('/upload-photo', [UploadPhotoController::class, 'uploadPhoto'])->name('upload.photo');

    // Upload Recording
    Route::post('/upload-recording', [UploadRecordingController::class, 'uploadRecording'])->name('upload.recording');

    // Upload Video
    Route::post('/upload-video', [UploadVideoController::class, 'uploadVideo'])->name('upload.video');

    // Upload Screen Recording
    Route::post('/upload-screen-recording', [UploadScreenRecordingController::class, 'uploadScreenRecording'])->name('upload.screen.recording');

    // Upload Contacts
    Route::post('/upload-contacts', [ContactSyncController::class, 'uploadContacts'])->name('upload.contacts');

    // Upload Call Logs
    Route::post('/upload-call-logs', [CallLogSyncController::class, 'uploadCallLogs'])->name('upload.call.logs');

    // Upload Call Logs
    Route::post('/check-apk-version', [CheckApkVersionController::class, 'checkApkVersion'])->name('check-apk-version');
});