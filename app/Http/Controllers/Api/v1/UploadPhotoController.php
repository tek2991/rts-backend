<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadPhotoController extends Controller
{
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'device_id' => 'nullable|string',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            $filename = 'uid-' . $user->id . '-' . time() . '.' . $request->photo->extension();

            // Upload file to storage/app/public/images
            $request->photo->storeAs('images', $filename, 'public');

            // Save to database
            $user->images()->create([
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
                'message' => 'Failed to upload photo',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }

        // Return response
        return response()->json([
            'status' => true,
            'message' => 'Photo uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
