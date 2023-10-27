<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GstController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CouponController;
use Illuminate\Contracts\Filesystem\Cloud;
use App\Http\Controllers\PackageController;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use App\Http\Controllers\ApkVersionController;
use App\Http\Controllers\ActivationCodeController;
use App\Http\Controllers\Client\LocatePhoneController;
use App\Http\Controllers\Client\SubscriptionController;
use App\Http\Controllers\Client\ClientPackageController;
use App\Http\Controllers\Client\PublicSubscriptionController;
use App\Http\Controllers\Client\PublicClientPackageController;
use App\Http\Controllers\Client\ClientActivationCodeController;

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
require_once base_path('routes/jetstream.php');

// Import Fortify routes fortify.php
require_once base_path('routes/fortify.php');

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Mobile Number Verification...
Route::get('/mobile-verification-notice', function () {
    return view('auth.verify-mobile-number');
})->middleware(['auth'])->name('mobile-verification-notice');

// Instamojo Webhook
Route::post('payment/instamojo/webhook', [App\Http\Controllers\Client\PaymentController::class, 'webhook'])->name('instamojo.payment.webhook');

// Phonepe Webhook
Route::post('payment/phonepe/webhook', [App\Http\Controllers\Client\PhonepeController::class, 'webhook'])->name('phonepe.payment.webhook');

// Public Dealers
Route::prefix('public')->name('public.')->group(function () {
    Route::resource('dealer', App\Http\Controllers\PublicDealerController::class)->only(['index', 'create', 'store']);

    Route::group(['middleware' => ['guest']], function () {
        Route::get('packages', [PublicClientPackageController::class, 'index'])->name('package.index');
        Route::get('packages/{package}', [PublicClientPackageController::class, 'show'])->name('package.show');
        Route::resource('subscription', PublicSubscriptionController::class)->only(['show', 'create']);
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    // 'verified',
    // 'verified.mobile',
])->group(function () {

    Route::prefix('client')->name('client.')->group(function () {
        Route::get('subscription/expired', [SubscriptionController::class, 'subscriptionExpired'])->name('subscription.expired');
        Route::resource('subscription', SubscriptionController::class)->only(['index', 'show', 'create']);
        Route::get('packages', [ClientPackageController::class, 'index'])->name('package.index');
        Route::get('packages/{package}', [ClientPackageController::class, 'show'])->name('package.show');

        Route::get('activation-code', [ClientActivationCodeController::class, 'start'])->name('activation-code.start');

        Route::get('instamojo/pay', [App\Http\Controllers\Client\PaymentController::class, 'pay'])->name('instamojo.payment.pay');
        Route::get('instamojo/success', [App\Http\Controllers\Client\PaymentController::class, 'success'])->name('instamojo.payment.success');
        // Route::get('payment/failure', [App\Http\Controllers\Client\PaymentController::class, 'failure'])->name('payment.failure'); // Not used

        Route::get('phonepe/pay', [App\Http\Controllers\Client\PhonepeController::class, 'pay'])->name('phonepe.payment.pay');
        Route::get('phonepe/success/{mid}/{mtid}/{shmtid}', [App\Http\Controllers\Client\PhonepeController::class, 'success'])->name('phonepe.payment.success');

        Route::get('/dashboard', function () {
            return view('client.dashboard');
        })->name('dashboard');

        // apk
        Route::get('apk', [App\Http\Controllers\AndroidApkController::class, 'index'])->name('apk.index');
        Route::get('apk/download', [App\Http\Controllers\AndroidApkController::class, 'download'])->name('apk.download');

        // Client routes protected by verified.client.has.subscription middleware
        Route::middleware(['verified.client.has.subscription'])->group(function () {
            
            // Control Phone
            Route::get('start-service', [App\Http\Controllers\Client\StartServiceController::class, 'index'])->name('start-service');


            // Locate Phone
            Route::get('locate-phone', [App\Http\Controllers\Client\LocatePhoneController::class, 'index'])->name('locate-phone');

            // Camera
            Route::get('camera', [App\Http\Controllers\Client\CameraController::class, 'index'])->name('camera');
            Route::delete('camera/{image}', [App\Http\Controllers\Client\CameraController::class, 'destroy'])->name('camera.destroy');

            // Message
            Route::get('message', [App\Http\Controllers\Client\MessageController::class, 'index'])->name('message');

            // Text to Speech
            Route::get('text-to-speech', [App\Http\Controllers\Client\TextToSpeechController::class, 'index'])->name('text-to-speech');

            // Contacts
            Route::get('contact', [App\Http\Controllers\Client\ContactController::class, 'index'])->name('contact');

            // Call Logs
            Route::get('call-log', [App\Http\Controllers\Client\CallLogController::class, 'index'])->name('call-log');

            // Lock Unlock
            Route::get('lock-unlock', [App\Http\Controllers\Client\LockUnlockController::class, 'index'])->name('lock-unlock');

            // Lost SMS
            Route::get('lost-sms', [App\Http\Controllers\Client\LostSmsController::class, 'index'])->name('lost-sms');

            // Voice Recorder
            Route::get('voice-recorder', [App\Http\Controllers\Client\VoiceRecorderController::class, 'index'])->name('voice-recorder');
            Route::delete('voice-recorder/{recording}', [App\Http\Controllers\Client\VoiceRecorderController::class, 'destroy'])->name('voice-recorder.destroy');

            // Screen Recorder
            Route::get('screen-recorder', [App\Http\Controllers\Client\ScreenRecorderController::class, 'index'])->name('screen-recorder');
            Route::delete('screen-recorder/{recording}', [App\Http\Controllers\Client\ScreenRecorderController::class, 'destroy'])->name('screen-recorder.destroy');

            // Video Recorder
            Route::get('video-recorder', [App\Http\Controllers\Client\VideoRecorderController::class, 'index'])->name('video-recorder');
            Route::delete('video-recorder/{video}', [App\Http\Controllers\Client\VideoRecorderController::class, 'destroy'])->name('video-recorder.destroy');

            // Fake Shurdown
            Route::get('fake-shutdown', [App\Http\Controllers\Client\FakeShutdownController::class, 'index'])->name('fake-shutdown');

            // Alert Device
            Route::get('alert-device', [App\Http\Controllers\Client\AlertDeviceController::class, 'index'])->name('alert-device');

            // Hide App
            Route::get('hide-app', [App\Http\Controllers\Client\HideAppController::class, 'index'])->name('hide-app');

            // Vibrate Phone
            Route::get('vibrate-phone', [App\Http\Controllers\Client\VibratePhoneController::class, 'index'])->name('vibrate-phone');
        });
    });

    Route::middleware(['redirect.if.client', 'role:administrator|manager'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

        // Test API
        Route::get('/test-api', function () {
            return view('test-api');
        })->name('test-api');

        // PHP Info
        Route::get('/php-info', function () {
            return view('php-info');
        })->name('php-info');

        // gst
        Route::resource('gst', GstController::class)->only(['index']);

        // Apk Version
        Route::resource('apk-version', ApkVersionController::class)->only(['index']);

        // users
        Route::resource('user', UserController::class);
        Route::delete('user/{user}/detatch-role/{role}', [UserController::class, 'detatchRole'])->name('user.detatchRole');
        Route::put('user/{user}/attach-role', [UserController::class, 'attachRole'])->name('user.attachRole');
        Route::put('user/{user}/reset-password', [UserController::class, 'resetPassword'])->name('user.resetPassword');

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

        // dealer
        Route::resource('dealer', App\Http\Controllers\DealerController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);

        // Dealer Submission
        Route::resource('dealer-submission', App\Http\Controllers\DealerSubmissionController::class)->only(['index']);

        // Payment
        Route::get('payment', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment.index');
        Route::get('payment/{payment}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');

        // send notification
        Route::post('/send-notification', function () {
            // Get request data
            $data = [
                'device_token' => request('device_token'),
                'title' => request('title'),
                'body' => request('body'),
                'action_to' => request('action_to'),
                'direct_boot_ok' => request('direct_boot_ok') ==  '1' ? true : false,
            ];

            // Send notification to device
            $message = CloudMessage::withTarget('token', $data['device_token'])
                ->withNotification(Notification::create($data['title'], $data['body']))
                ->withData([
                    'action_to' => $data['action_to'],
                ])
                ->withAndroidConfig([
                    'priority' => 'high',
                    'direct_boot_ok' => $data['direct_boot_ok'],
                ]);

            // $message = CloudMessage::fromArray([
            //     'token' => $data['device_token'],
            //     'notification' => Notification::fromArray([
            //         'title' => $data['title'],
            //         'body' => $data['body'],
            //     ]),
            //     'android' => [
            //         'direct_boot_ok' => $data['direct_boot_ok'],
            //     ],
            //     'data' => [
            //         'action_to' => $data['action_to'],
            //     ],
            // ]);

            // dd($message);

            $messaging = app('firebase.messaging');

            $messaging->send($message);

            return back()->banner('Notification sent!');
        })->name('send-notification');
    });
});
