<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;



class ContactSyncController extends Controller
{
    /**
     * Upload contacts.
     *
     * Uploads and stores contacts from a JSON file. Existing contacts will be updated.
     *
     * @group Features
     * @authenticated
     *
     * @bodyParam device_id string optional The device ID. If not provided, the user's default device ID will be used.
     * @bodyParam json_file file required The JSON file containing contacts to upload.
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Contacts uploaded",
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
     *     "message": "Failed to upload contacts",
     *     "errors": {
     *         "exception": ["Exception message"],
     *         "trace": ["Exception trace"]
     *     },
     *     "data": {}
     * }
     */
    public function uploadContacts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'nullable|string',
            'json_file' => 'required|file|mimes:json,txt|max:10000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to upload contacts',
                'errors' => (object)$validator->errors()->toArray(),
                'data' => (object)[],
            ], 422);
        }

        $data = $request->only(['device_id', 'json_file']);

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
        $json_file_path = 'contacts/' . $json_file->getClientOriginalName();
        $json_file->storeAs('contacts', $json_file->getClientOriginalName());

        // Read the file contents
        $json_file_content = file_get_contents(storage_path('app/' . $json_file_path));
        $json_file_content = json_decode($json_file_content, true);

        try {
            $contacts = $json_file_content['data'];

            $contactsToInsert = [];
            $now = now();

            
            foreach ($contacts as $contact) {
                $contactsToInsert[] = [
                    'user_id' => $user->id,
                    'name' => isset($contact['name']) ? $contact['name'] : null,
                    'number' => isset($contact['number']) ? $contact['number'] : null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            foreach (array_chunk($contactsToInsert, 1000) as $chunk) {
                // Check if the number already exists in the database
                $existingContacts = DB::table('contacts')
                    ->where('user_id', $user->id)
                    ->whereIn('number', array_column($chunk, 'number'))
                    ->get();

                // Remove the existing contacts from the chunk
                $chunk = array_filter($chunk, function ($contact) use ($existingContacts) {
                    foreach ($existingContacts as $existingContact) {
                        if ($existingContact->number == $contact['number']) {
                            return false;
                        }
                    }

                    return true;
                });

                // Insert the chunk
                DB::table('contacts')->insert($chunk);

                // Update the existing contacts
                foreach ($existingContacts as $existingContact) {
                    foreach ($chunk as $contact) {
                        if ($existingContact->number == $contact['number']) {
                            DB::table('contacts')
                                ->where('id', $existingContact->id)
                                ->update([
                                    'name' => $contact['name'],
                                    'updated_at' => $now,
                                ]);
                        }
                    }
                }
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
                'message' => 'Failed to upload contacts',
                'errors' => $errors,
                'data' => (object)[],
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Contacts uploaded',
            'errors' => (object)[],
            'data' => (object)[],
        ], 200);
    }
}
