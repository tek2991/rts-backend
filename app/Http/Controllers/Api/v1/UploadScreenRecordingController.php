<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UploadScreenRecordingController extends Controller
{
    /**
     * Upload screen recording.
     *
     * Uploads and stores a screen recording for the authenticated user.
     *
     * @group Features
     * @authenticated
     *
     * @bodyParam device_id string optional The device ID. If not provided, the user's default device ID will be used.
     * @bodyParam recording file required The screen recording to upload (MP4, MOV, OGG, QT). Max size: 15MB.
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
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'recording' => 'required|file|mimes:mp4,mov,ogg,qt|max:15000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to upload screen recording',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }

        $data = $request->only(['device_id', 'recording']);

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
            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->id . '-' . $uuid . '.' . $request->recording->extension();

            // Upload file to s3 bucket under 'screen-recordings' folder
            $request->recording->storeAs('screen-recordings', $filename, 's3');

            // Save to database
            $user->screenRecordings()->create([
                'filename' => $filename,
                'device_id' => $device_id,
            ]);
        } catch (\Throwable $th) {
            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$th->getMessage()],
                    'trace' => $th->getTrace(),
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
