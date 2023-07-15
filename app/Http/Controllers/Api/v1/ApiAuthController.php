<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use App\Http\Controllers\Controller;

class ApiAuthController extends Controller
{
    /**
     * Log in a user using email and password.
     *
     * @group Authentication
     * 
     * @bodyParam email string required User's email address.
     * @bodyParam password string required User's password.
     * 
     * @response {
     *    "status": true,
     *    "message": "Login Success",
     *    "errors": {},
     *    "data": {
     *        "name": "John Doe",
     *        "email": "john@example.com",
     *        "email_verified": true,
     *        "mobile_number": "1234567890",
     *        "mobile_number_verified": true,
     *        "has_active_subscription": true,
     *        "subscribed_upto": "2023-12-31",
     *        "purchase_url": "in-app-purchase-url",
     *        "device_id": "ABC123",
     *        "device_token": "XYZ789",
     *        "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiaWF0IjoxNjI2MzM2MzE3LCJleHAiOjE2MjYzMzY5MTd9.sX5EBhtd4IM2AtS-7HErAtX5umc6AdncEa4fUcF6zGw"
     *    }
     * }
     * 
     * @response 401 {
     *    "status": false,
     *    "message": "Login Failed",
     *    "errors": {
     *        "email": [
     *            "Invalid email or password"
     *        ]
     *    },
     *    "data": {}
     * }
     * 
     * @response 500 {
     *    "status": false,
     *    "message": "Login Failed",
     *    "errors": {
     *        "exception": "Exception message",
     *        "trace": "Exception trace"
     *    },
     *    "data": {}
     * }
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function emailLogin()
    {
        // Validate the request...
        $credentials = request(['email', 'password']);

        try {
            if (!auth()->attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Login Failed',
                    'errors' => (object)[
                        'email' => ['Invalid email or password'],
                    ],
                    'data' => (object)[],
                ], 401);
            }

            $user = auth()->user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login Success',
                'errors' => (object)[],
                'data' => (object)[
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified' => $user->hasVerifiedEmail(),
                    'mobile_number' => $user->mobile_number,
                    'mobile_number_verified' => $user->hasVerifiedMobileNumber(),
                    'has_active_subscription' => $user->hasActiveSubscription(),
                    'subscribed_upto' => $user->subscribedUpto(),
                    'purchase_url' => 'in-app-purchase-url',
                    'device_id' => $user->device_id,
                    'device_token' => $user->device_token,
                    'token' => $token,
                ],
            ]);
        } catch (\Exception $e) {
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ];
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Failed',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }
    }

    /**
     * Send OTP to mobile number for verification.
     *
     * @group Authentication
     * 
     * @bodyParam mobile_number int required User's mobile number.
     * 
     * @response {
     *    "status": true,
     *    "message": "OTP Sent",
     *    "errors": {},
     *    "data": {
     *        "otp": "123456"
     *    }
     * }
     * 
     * @response 404 {
     *    "status": false,
     *    "message": "User not found",
     *    "errors": {
     *        "mobile_number": [
     *            "User not found"
     *        ]
     *    },
     *    "data": {}
     * }
     * 
     * @response 500 {
     *    "status": false,
     *    "message": "OTP Failed",
     *    "errors": {
     *        "exception": "Exception message",
     *        "trace": "Exception trace"
     *    },
     *    "data": {}
     * }
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobileOtp()
    {
        // Validate the request...
        $credentials = request(['mobile_number']);

        try {
            // Check if user with mobile number exists
            $user = User::where('mobile_number', $credentials['mobile_number'])->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'errors' => (object)[
                        'mobile_number' => ['User not found'],
                    ],
                    'data' => (object)[],
                ], 404);
            }

            // Generate OTP
            $otp = $user->sendMobileNumberVerificationNotification();
            return response()->json([
                'status' => true,
                'message' => 'OTP Sent',
                'errors' => (object)[],
                'data' => [
                    'otp' => $otp,
                ],
            ]);
        } catch (\Exception $e) {
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ];
            }
            return response()->json([
                'status' => false,
                'message' => 'OTP Failed',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }
    }

    /**
     * Verify OTP for mobile number.
     *
     * @group Authentication
     * 
     * @bodyParam mobile_number int required User's mobile number.
     * @bodyParam otp string required OTP for verification.
     * 
     * @response {
     *    "status": true,
     *    "message": "Login Success",
     *    "errors": {},
     *    "data": {
     *        "name": "John Doe",
     *        "email": "john@example.com",
     *        "email_verified": true,
     *        "mobile_number": "1234567890",
     *        "mobile_number_verified": true,
     *        "has_active_subscription": true,
     *        "subscribed_upto": "2023-12-31",
     *        "purchase_url": "in-app-purchase-url",
     *        "device_id": "ABC123",
     *        "device_token": "XYZ789",
     *        "token": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6MSwiaWF0IjoxNjI2MzM2MzE3LCJleHAiOjE2MjYzMzY5MTd9.sX5EBhtd4IM2AtS-7HErAtX5umc6AdncEa4fUcF6zGw"
     *    }
     * }
     * 
     * @response 401 {
     *    "status": false,
     *    "message": "OTP verification failed",
     *    "errors": {
     *        "otp": [
     *            "OTP verification failed"
     *        ]
     *    },
     *    "data": {}
     * }
     * 
     * @response 404 {
     *    "status": false,
     *    "message": "User not found",
     *    "errors": {
     *        "mobile_number": [
     *            "User not found"
     *        ]
     *    },
     *    "data": {}
     * }
     * 
     * @response 500 {
     *    "status": false,
     *    "message": "Login Failed",
     *    "errors": {
     *        "exception": "Exception message",
     *        "trace": "Exception trace"
     *    },
     *    "data": {}
     * }
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function mobileOtpVerify()
    {
        // Validate the request...
        $credentials = request(['mobile_number', 'otp']);

        try {
            // Check if user with mobile number exists
            $user = User::where('mobile_number', $credentials['mobile_number'])->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                    'errors' => (object)[
                        'mobile_number' => ['User not found'],
                    ],
                    'data' => (object)[],
                ], 404);
            }

            // Verify OTP
            $otp_verified = $user->verifyMobileNumber($credentials['otp']);

            if (!$otp_verified) {
                return response()->json([
                    'status' => false,
                    'message' => 'OTP verification failed',
                    'errors' => (object)[
                        'otp' => ['OTP verification failed'],
                    ],
                    'data' => (object)[],
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login Success',
                'errors' => (object)[],
                'data' => (object)[
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified' => $user->hasVerifiedEmail(),
                    'mobile_number' => $user->mobile_number,
                    'mobile_number_verified' => $user->hasVerifiedMobileNumber(),
                    'has_active_subscription' => $user->hasActiveSubscription(),
                    'subscribed_upto' => $user->subscribedUpto(),
                    'purchase_url' => 'in-app-purchase-url',
                    'device_id' => $user->device_id,
                    'device_token' => $user->device_token,
                    'token' => $token,
                ],
            ]);
        } catch (\Exception $e) {
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ];
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Failed',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }
    }
}
