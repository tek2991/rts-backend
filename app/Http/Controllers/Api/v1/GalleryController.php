<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Check device photos
     *
     * Checks if the device has any photos. If the device ID is not provided, the user's default device ID will be used.
     *
     * @group Features
     * @authenticated
     *
     * @bodyParam device_id string optional The device ID. If not provided, all devices will be checked.
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Device gallery check successful",
     *     "errors": {},
     *     "data": {}
     * }
     * }
     * @response 500 {
     *     "status": false,
     *     "message": "Failed to check device gallery",
     *     "errors": {
     *         "exception": ["Exception Log"],
     *         "trace": ["Exception trace"]
     *     },
     *     "data": {}
     * }
     */
    public function listPhotos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Device gallery check failed',
                    'errors' => (object) $validator->errors()->toArray(),
                    'data' => (object) [],
                ],
                422,
            );
        }

        $data = $request->only(['device_id']);

        // Get user
        $user = auth()->user();

        $device_id = $data['device_id'] ?? null;

        try {
            $query = GalleryItem::where('user_id', $user->id)
                ->select('device_id', 'device_gallery_id', 'media_url', 'media_type', 'created_at');

            if ($device_id) {
                $query->where('device_id', $device_id);
            }

            $photos = $query->get();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Device gallery check successful',
                    'errors' => (object) [],
                    'data' => $photos,
                ],
                200,
            );
        } catch (\Exception $e) {
            $errors = (object) [];
            if (config('app.debug')) {
                $errors = (object) [
                    'exception' => [$e->getMessage()],
                    'trace' => $e->getTrace(),
                ];
            }

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to check device gallery',
                    'errors' => $errors,
                    'data' => (object) [],
                ],
                500,
            );
        }
    }


    /**
     * Upload device photo
     *
     * Uploads a photo to the device gallery. If the device ID is not provided, the user's default device ID will be used.
     *
     * @group Features
     * @authenticated
     *
     * @bodyParam device_id string optional The device ID. If not provided, the user's default device ID will be used.
     * @bodyParam photo_id string required The ID of the photo to upload to.
     * @bodyParam photo file required The photo to upload (JPEG, PNG, JPG, GIF, SVG). Max size: 2048 KB.
     * @bodyParam overwrite boolean optional If true, the photo will be overwritten if it already exists. Default: false.
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Device gallery upload successful",
     *     "errors": {},
     *     "data": {}
     * }
     * }
     * @response 500 {
     *     "status": false,
     *     "message": "Failed to upload photo",
     *     "errors": {
     *         "exception": ["Exception Log"],
     *         "trace": ["Exception trace"]
     *     },
     *     "data": {}
     * }
     */
    public function uploadPhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required',
            'photo_id' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'overwrite' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to upload photo',
                    'errors' => (object) $validator->errors()->toArray(),
                    'data' => (object) [],
                ],
                422,
            );
        }

        $data = $request->only(['device_id', 'photo']);

        // Get user
        $user = auth()->user();
        $device_id = $data['device_id'] ?? $user->device_id;

        $exists = GalleryItem::where('device_gallery_id', $request->photo_id)
            ->where('device_id', $device_id)
            ->where('user_id', $user->id)
            ->exists();

        if(!$request->overwrite) {
            if ($exists) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Photo already exists',
                        'errors' => (object) [],
                        'data' => (object) [],
                    ],
                    406,
                );
            }
        }

        if (!$device_id) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'No device found',
                    'errors' => (object) [],
                    'data' => (object) [],
                ],
                406,
            );
        }

        try {
            if($request->overwrite && $exists) {
                $model = GalleryItem::where('device_gallery_id', $request->photo_id)
                    ->where('device_id', $device_id)
                    ->where('user_id', $user->id)
                    ->first();

                
                // Delete from s3 bucket
                $exists = \Storage::disk('s3')->exists('gallery/images/' . $model->media_url);
                if ($exists) {
                    \Storage::disk('s3')->delete('gallery/images/' . $model->media_url);
                }
                
                // Delete from database
                $model->delete();
            }
            
            // Generate filename
            $uuid = \Ramsey\Uuid\Uuid::uuid4();
            $filename = 'uid-' . $user->id . '-' . $uuid . '-' . $request->photo_id .  '.' . $request->photo->extension();

            // Upload file to s3 bucket under 'images' folder
            $path = $request->photo->storeAs('gallery/images', $filename, 's3');

            // Save to database
            $gallery_item = GalleryItem::create([
                'device_gallery_id' => $request->photo_id,
                'device_id' => $device_id,
                'user_id' => $user->id,
                'media_type' => 'image',
                'media_url' => $filename,
            ]);

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Photo uploaded successfully',
                    'errors' => (object) [],
                    'data' => $gallery_item,
                    'path' => $path,
                ],
                200,
            );
        } catch (\Throwable $th) {
            $errors = (object) [];
            if (config('app.debug')) {
                $errors = (object) [
                    'exception' => [$th->getMessage()],
                    'trace' => $th->getTrace(),
                ];
            }

            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to upload photo',
                    'errors' => $errors,
                    'data' => (object) [],
                ],
                500,
            );
        }
    }
}
