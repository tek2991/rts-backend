<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SyncController extends Controller
{
    /**
     * Sync user data.
     *
     * @group User Management
     * @authenticated
     *
     * @bodyParam email string required The email of the user.
     * @bodyParam mobile_number int required The mobile number of the user.
     * @bodyParam device_id string nullable The device ID of the user.
     * @bodyParam device_token string nullable The device token of the user.
     * @bodyParam force_sync boolean required Flag indicating whether to force a device sync.
     *
     * @response 200 {
     *    "status": true,
     *    "message": "Sync successful",
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
     *        "device_token": "XYZ789"
     *    }
     * }
     *
     * @response 401 {
     *    "status": false,
     *    "message": "Unauthorized",
     *    "errors": {
     *        "email": ["The email and mobile number do not match."],
     *        "mobile_number": ["The email and mobile number do not match."]
     *    },
     *    "data": {}
     * }
     *
     * @response 409 {
     *    "status": false,
     *    "message": "Duplicate device",
     *    "errors": {},
     *    "data": {}
     * }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function sync(Request $request)
    {
        // Validate the request...
        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
            'mobile_number' => 'required|numeric|exists:users,mobile_number',
            'device_id' => 'nullable|string',
            'device_token' => 'nullable|string',
            'force_sync' => 'required|boolean',
        ]);

        // Check if authenticated user has the same email and mobile number
        $user = User::where('email', $data['email'])
            ->where('mobile_number', $data['mobile_number'])
            ->firstOrFail();

        if (auth()->user()->id != $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'errors' => (object)[
                    'email' => ['The email and mobile number does not match.'],
                    'mobile_number' => ['The email and mobile number does not match.'],
                ],
                'data' => (object)[],
            ], 401);
        }

        if ($data['force_sync']) {
            $user->device_id = $data['device_id'];
            $user->device_token = $data['device_token'];
            $user->save();
        }

        // If device_id and device_token are empty or force_scan is true, then update the device_id and device_token
        if ((empty($user->device_id) && empty($user->device_token)) || ($user->device_id == $data['device_id'] && $user->device_token == $data['device_token'])) {
            return response()->json([
                'status' => true,
                'message' => 'Sync successful',
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
                ],
            ], 200);
        }

        // If device_id and device_token are not empty and force_scan is false, then return error
        return response()->json([
            'status' => false,
            'message' => 'Duplicate device',
            'errors' => (object)[],
            'data' => (object)[],
        ], 409);
    }

    /**
     * Update device status.
     *
     * @group User Management
     * @authenticated
     *
     * @bodyParam email string required The email of the user.
     * @bodyParam mobile_number int required The mobile number of the user.
     * @bodyParam device_id string required The device ID of the user.
     * @bodyParam device_status json required The device status of the user.
     *
     * @response 200 {
     *    "status": true,
     *    "message": "Device status updated",
     *    "errors": {},
     *    "data": {}
     * }
     *
     * @response 401 {
     *    "status": false,
     *    "message": "Unauthorized",
     *    "errors": {
     *        "email": ["The email and mobile number do not match."],
     *        "mobile_number": ["The email and mobile number do not match."]
     *    },
     *    "data": {}
     * }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deviceStatus(Request $request)
    {
        // Validate the request...
        $data = $request->validate([
            'email' => 'required|email|exists:users,email',
            'mobile_number' => 'required|numeric|exists:users,mobile_number',
            'device_id' => 'required|string',
            'device_status' => 'required|json',
        ]);

        // Check if authenticated user has the same email and mobile number
        $user = User::where('email', $data['email'])
            ->where('mobile_number', $data['mobile_number'])
            ->firstOrFail();

        if (auth()->user()->id != $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'errors' => (object)[
                    'email' => ['The email and mobile number does not match.'],
                    'mobile_number' => ['The email and mobile number does not match.'],
                ],
                'data' => (object)[],
            ], 401);
        }

        // Convert device_status to array
        $data['device_status'] = json_decode($data['device_status'], true);
        $user->device_status = $data['device_status'];
        $user->device_status_updated_at = now();
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Device status updated',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
