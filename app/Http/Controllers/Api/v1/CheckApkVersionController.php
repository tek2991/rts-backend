<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CheckApkVersionController extends Controller
{
    /**
     * Check Api Version.
     *
     * @group User Management
     * @authenticated
     *
     * @bodyParam apk_version integer required The current apk version of the device.
     *
     * @response 200 {
     *    "status": true,
     *    "message": "Apk version ok",
     *    "errors": {},
     *    "data": {}
     * }
     *
     * @response 401 {
     *    "status": false,
     *    "message": "Unauthorized",
     *    "errors": {
     *        "apk_version": ["Apk version is out of date"],
     *    },
     *    "data": {
     *        "latest_version": ["10"]
     *    }
     * }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkApkVersion(Request $request)
    {
        // Validate the request...
        $validator = Validator::make($request->all(), [
            'apk_version' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Device apk version check failed',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }

        $data = $request->only(['apk_version']);

        $apkVersionModel = \App\Models\ApkVersion::first();

        if ($apkVersionModel->version > $data['apk_version']) {
            return response()->json([
                'status' => false,
                'message' => 'Update available',
                'errors' => (object)[],
                'data' => (object)[],
            ], 200);
        } else if ($apkVersionModel->version < $data['apk_version']) {
            return response()->json([
                'status' => false,
                'message' => 'Out of bounds',
                'errors' => (object)[],
                'data' => (object)[],
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Apk version ok',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
