<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;

class ApiAuthController extends Controller
{
    /**
     * Handle an incoming authentication request using email and password.
     *
     * @return \Illuminate\Http\Response
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
     * Handle an incoming authentication request for generating mobile OTP.
     *
     * @return \Illuminate\Http\Response
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
     * Handle an incoming authentication request using mobile number and OTP.
     *
     * @return \Illuminate\Http\Response
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

            // Sign in user
            // auth()->login($user);
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
