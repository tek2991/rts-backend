<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UploadRecordingController extends Controller
{
    /**
     * Upload audio recording.
     *
     * Uploads and stores a audio recording for the authenticated user.
     *
     * @group Features
     * @authenticated
     *
     * @bodyParam device_id string optional The device ID. If not provided, the user's default device ID will be used.
     * @bodyParam recording file required The audio recording to upload (MP3, WAV, OGG, AAC). Max size: 2048 KB.
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
     *     "message": "Failed to upload recording",
     *     "errors": {
     *         "exception": ["Exception message"],
     *         "trace": ["Exception trace"]
     *     },
     *     "data": {}
     * }
     */
    public function uploadRecording(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'recording' => 'required|file|mimes:mp3,wav,ogg,aac|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to upload recording',
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

            // Upload file to s3 bucket under 'recordings' folder
            $request->recording->storeAs('recordings', $filename, 's3');

            // Save to database
            $user->recordings()->create([
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
                'message' => 'Failed to upload recording',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }

        // Return response
        return response()->json([
            'status' => true,
            'message' => 'Recording uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
