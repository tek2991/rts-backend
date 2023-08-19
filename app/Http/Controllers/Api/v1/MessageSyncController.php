<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;



class MessageSyncController extends Controller
{

    /**
     * Get the last message for the user.
     *
     * Retrieves the last message based on the provided criteria.
     *
     * @group Features
     * @authenticated
     *
     * @queryParam device_id string optional The device ID. If not provided, the user's default device ID will be used.
     * @queryParam inbox boolean required Whether to retrieve messages from the inbox. Use "true" for inbox, "false" for outbox.
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Last message retrieved",
     *     "errors": {},
     *     "data": {
     *         "last_message": {
     *             "message_id": 123,
     *             "device_id": "abc123",
     *             "number": "1234567890",
     *             "date": "2023-08-19",
     *             "body": "This is the message content.",
     *             "is_inbox": true
     *         }
     *     }
     * }
     * 
     *  @response 406 {
     *     "status": false,
     *     "message": "No device ID found or no messages found",
     *     "errors": {},
     *     "data": {}
     * }
     * 
     * @response 404 {
     *     "status": false,
     *     "message": "No messages found",
     *     "errors": {},
     *     "data": {}
     * }
     */
    public function getLastMessage(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'nullable|string',
            'inbox' => 'required|boolean',
        ]);

        $user = $request->user();
        $device_id = $data['device_id'] ?? $user->device_id;

        if (!$device_id) {
            return response()->json([
                'status' => false,
                'message' => 'No device ID found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 406);
        }

        $last_message = $user->messages()
            ->where('device_id', $device_id)
            ->where('is_inbox', $data['inbox'])
            ->orderBy('message_id', 'desc')
            ->first();

        if (!$last_message) {
            return response()->json([
                'status' => false,
                'message' => 'No messages found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Last message retrieved',
            'errors' => (object)[],
            'data' => (object)[
                'last_message' => (object)[
                    'message_id' => $last_message->message_id,
                    'device_id' => $last_message->device_id,
                    'number' => $last_message->number,
                    'date' => $last_message->date,
                    'body' => $last_message->body,
                    'is_inbox' => $last_message->is_inbox,
                ]
            ],
        ], 200);
    }

    
    /**
     * Upload and store messages from a JSON file.
     *
     * Uploads and stores messages from a JSON file into the user's inbox or outbox.
     *
     * @group Features
     * @authenticated
     *
     * @bodyParam device_id string optional The device ID. If not provided, the user's default device ID will be used.
     * @bodyParam inbox boolean required Whether to upload messages to the inbox. Use "true" for inbox, "false" for outbox.
     * @bodyParam json_file file required The JSON file containing messages to upload.
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Messages uploaded",
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
     *     "message": "Failed to upload messages",
     *     "errors": {
     *         "exception": ["Exception message"],
     *         "trace": ["Exception trace"]
     *     },
     *     "data": {}
     * }
     */
    public function uploadMessages(Request $request)
    {
        $data = $request->validate([
            'device_id' => 'nullable|string',
            'inbox' => 'required|boolean',
            'json_file' => 'required|file',
        ]);

        $user = $request->user();
        $device_id = $data['device_id'] ?? $user->device_id;

        if (!$device_id) {
            return response()->json([
                'status' => false,
                'message' => 'No device found',
                'errors' => (object)[],
                'data' => (object)[],
            ], 406);
        }

        $json_file = $data['json_file'];
        // Store the file in storage/app/messages/inbox or storage/app/messages/outbox
        $json_file_path = 'messages/' . ($data['inbox'] ? 'inbox' : 'outbox') . '/' . $json_file->getClientOriginalName();
        $json_file->storeAs('messages/' . ($data['inbox'] ? 'inbox' : 'outbox'), $json_file->getClientOriginalName());

        // Read the file contents
        $json_file_content = file_get_contents(storage_path('app/' . $json_file_path));
        $json_file_content = json_decode($json_file_content, true);

        try {
            $messages = $json_file_content['messages'];

            $messagesToInsert = [];
            $now = now();

            foreach ($messages as $message) {
                $message['user_id'] = $user->id;
                $message['device_id'] = $device_id;
                $message['message_id'] = $message['message_id'];
                $message['number'] = $message['number'];
                $message['date'] = $message['date'];
                $message['body'] = $message['body'];
                $message['is_inbox'] = $data['inbox'];
                $message['created_at'] = $now;
                $message['updated_at'] = $now;
                $messagesToInsert[] = $message;
            }

            DB::table('messages')->insert($messagesToInsert);

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
                'message' => 'Failed to upload messages',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Messages uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
