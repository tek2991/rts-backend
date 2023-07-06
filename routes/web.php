<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CouponController;
use Illuminate\Contracts\Filesystem\Cloud;
use App\Http\Controllers\PackageController;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Http\Controllers\ActivationCodeController;
use App\Http\Controllers\Client\SubscriptionController;
use App\Http\Controllers\Client\ClientPackageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Import Jetstream routes jetsream.php
// require_once base_path('routes/jetstream.php');

// Import Fortify routes fortify.php
// require_once base_path('routes/fortify.php');

Route::get('/', function () {
    return redirect()->route('login');
});

// Mobile Number Verification...
Route::get('/mobile-verification-notice', function () {
    return view('auth.verify-mobile-number');
})->middleware(['auth'])->name('mobile-verification-notice');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'verified.mobile',
])->group(function () {
    
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('subscription/expired', [SubscriptionController::class, 'subscriptionExpired'])->name('subscription.expired');
        Route::resource('subscription', SubscriptionController::class)->only(['index', 'show', 'create', 'store']);
        Route::get('packages', [ClientPackageController::class, 'index'])->name('package.index');
        Route::get('packages/{package}', [ClientPackageController::class, 'show'])->name('package.show');

        Route::middleware(['verified.client.has.subscription'])->group(function () {
            // Client routes
            Route::get('/dashboard', function () {
                return view('client.dashboard');
            })->name('dashboard');
        });
    });

    Route::middleware(['redirect.if.client', 'role:administrator|manager'])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // users
        Route::resource('user', UserController::class);
        Route::delete('user/{user}/detatch-role/{role}', [UserController::class, 'detatchRole'])->name('user.detatchRole');
        Route::put('user/{user}/attach-role', [UserController::class, 'attachRole'])->name('user.attachRole');

        // roles
        Route::resource('role', RoleController::class);
        Route::delete('role/{role}/detatch-permission/{permission}', [RoleController::class, 'detatchPermission'])->name('role.detatchPermission');
        Route::put('role/{role}/attach-permission', [RoleController::class, 'attachPermission'])->name('role.attachPermission');

        // package
        Route::resource('package', PackageController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);

        // coupon
        Route::resource('coupon', CouponController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);

        // activation code
        Route::resource('activation-code', ActivationCodeController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);

        // send notification
        Route::post('/send-notification', function () {
            // Get request data
            $data = [
                'device_token' => request('device_token'),
                'title' => request('title'),
                'body' => request('body'),
                'action_to' => request('action_to'),
            ];

            // Send notification to device
            $message = CloudMessage::withTarget('token', $data['device_token'])
                ->withNotification(Notification::create($data['title'], $data['body']))
                ->withData(['action_to' => $data['action_to']]);


            $messaging = app('firebase.messaging');

            $messaging->send($message);

            return back()->banner('Notification sent!');
        })->name('send-notification');
    });
});
