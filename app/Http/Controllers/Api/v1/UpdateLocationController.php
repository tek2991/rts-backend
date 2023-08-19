<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UpdateLocationController extends Controller
{
    /**
     * Update the user's device location.
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
        $request->validate([
            'device_id' => 'nullable',
            'lat' => 'required',
            'lng' => 'required',
        ]);

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
