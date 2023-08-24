<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class CallLogSyncController extends Controller
{
    /**
     * Upload and store call logs from a JSON file.
     *
     * Uploads and stores call logs from a JSON file. Maximum 500 records will be saved. Older records will be deleted.
     *
     * @group Features
     * @authenticated
     *
     * @bodyParam json_file file required The JSON file containing callLogs to upload.
     *
     * @response 200 {
     *     "status": true,
     *     "callLog": "call logs uploaded",
     *     "errors": {},
     *     "data": {}
     * }
     * @response 406 {
     *     "status": false,
     *     "callLog": "No device found",
     *     "errors": {},
     *     "data": {}
     * }
     * @response 500 {
     *     "status": false,
     *     "callLog": "Failed to upload call logs",
     *     "errors": {
     *         "exception": ["Exception Log"],
     *         "trace": ["Exception trace"]
     *     },
     *     "data": {}
     * }
     */
    public function uploadCallLogs(Request $request)
    {
        $data = $request->validate([
            'json_file' => 'required|file',
        ]);

        $json_file = $data['json_file'];

        // Store the file in storage/app/callLogs/
        $json_file_path = 'callLogs/' . $json_file->getClientOriginalName();
        $json_file->storeAs('callLogs/', $json_file->getClientOriginalName());

        // Read the file contents
        $json_file_content = file_get_contents(storage_path('app/' . $json_file_path));
        $json_file_content = json_decode($json_file_content, true);

        try {
            $callLogs = $json_file_content['data'];

            $callLogsToInsert = [];
            $now = now();

            $user_id = auth()->user()->id;

            foreach ($callLogs as $callLog) {
                $callLog['user_id'] = $user_id;
                $callLog['name'] = $callLog['name'];
                $callLog['number'] = $callLog['number'];
                $callLog['duration'] = $callLog['duration'];
                $callLog['date'] = $callLog['date'];
                $callLog['created_at'] = $now;
                $callLog['updated_at'] = $now;
                $callLogsToInsert[] = $callLog;
            }

            foreach (array_chunk($callLogsToInsert, 1000) as $chunk) {
                DB::table('call_logs')->insert($chunk);
            }

            // Delete old records if more than 500
            $count = DB::table('call_logs')->where('user_id', $user_id)->count();
            if ($count > 500) {
                $countToDelete = $count - 500;
                DB::table('call_logs')->where('user_id', $user_id)->orderBy('id', 'asc')->limit($countToDelete)->delete();
            }

            // Delete the file
            unlink(storage_path('app/' . $json_file_path));
        } catch (\Exception $e) {
            // Delete the file
            unlink(storage_path('app/' . $json_file_path));

            $errors = (object)[];
            if (config('app.debug')) {
                $errors = (object)[
                    'exception' => [$e->getMessage()],
                    'trace' => $e->getTrace(),
                ];
            }

            return response()->json([
                'status' => false,
                'callLog' => 'Failed to upload call logs',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }

        return response()->json([
            'status' => true,
            'callLog' => 'call logs uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
