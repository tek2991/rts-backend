<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UpdateLocationController extends Controller
{
    /**
     * Update device location.
     *
     * Updates the user's device location using the provided latitude and longitude.
     *
     * @group Features
     * @authenticated
     *
     * @bodyParam device_id string optional The device ID to update. If not provided, the user's default device ID will be used.
     * @bodyParam lat float required The new latitude.
     * @bodyParam lng float required The new longitude.
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Device location updated",
     *     "errors": {},
     *     "data": {}
     * }
     * @response 406 {
     *     "status": false,
     *     "message": "No device found",
     *     "errors": {},
     *     "data": {}
     * }
     */
    public function updateLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullabl',
            'lat' => 'required',
            'lng' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Device location update failed',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }

        $data = $request->only(['device_id', 'lat', 'lng']);

        // Get user
        $user = auth()->user();

        $device_id = $data['device_id'] ?? $user->device_id;

        if (!$device_id) {
            return response()->json([
                'status' => false,
                'message' => 'No device found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 406);
        }

        auth()->user()->update([
            'lat' => $request->lat,
            'lng' => $request->lng,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Device location updated',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
