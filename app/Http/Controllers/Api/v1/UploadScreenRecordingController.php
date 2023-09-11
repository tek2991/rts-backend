<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadScreenRecordingController extends Controller
{
    /**
     * Upload and store a user's screen recording.
     *
     * Uploads and stores a screen recording for the authenticated user.
     *
     * @group Features
     * @authenticated
     *
     * @bodyParam device_id string optional The device ID. If not provided, the user's default device ID will be used.
     * @bodyParam recording file required The screen recording to upload (MP4). Max size: 2048 KB.
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Recording uploaded",
     *     "errors": {},
     *     "data": {}
     * }
     * @response 406 {
     *     "status": false,
     *     "message": "No device found",
     *     "errors": {},
     *     "data": {}
     * }
     * @response 500 {
     *     "status": false,
     *     "message": "Failed to upload screen recording",
     *     "errors": {
     *         "exception": ["Exception message"],
     *         "trace": ["Exception trace"]
     *     },
     *     "data": {}
     * }
     */
    public function uploadScreenRecording(Request $request)
    {
        $request->validate([
            'device_id' => 'nullable|string',
            'recording' => 'required|file|mimes:mp4|max:2048',
        ]);

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

        try {
            // Generate filename
            $filename = 'uid-' . $user->id . '-' . time() . '.' . $request->recording->extension();

            // Upload file to storage/app/public/recordings
            $request->recording->storeAs('screen-recordings', $filename, 'public');

            // Save to database
            $user->screenRecordings()->create([
                'filename' => $filename,
                'device_id' => $device_id,
            ]);
        } catch (\Throwable $th) {
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$e->getMessage()],
                    'trace' => $e->getTrace(),
                ];
            }

            return response()->json([
                'status' => false,
                'message' => 'Failed to upload screen recording',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }

        // Return response
        return response()->json([
            'status' => true,
            'message' => 'Screen Recording uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
