<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Dealer;
use Illuminate\Http\Request;
use App\Models\DealerSubmission;
use App\Http\Controllers\Controller;

class DealerController extends Controller
{
    /**
     * Retrieve a list of dealers.
     *
     * @group Dealers
     * @get
     * @url /api/dealers
     * @queryParam per_page The number of items per page (default: 15).
     * @queryParam page The current page number (default: 1).
     *
     * @response 200 {
     *     "status": true,
     *     "message": "Dealers",
     *     "data": {
     *         "current_page": 1,
     *         "data": [
     *             // List of dealer objects
     *         ],
     *         "first_page_url": "http://localhost:8000/api/dealers?page=1",
     *         "from": 1,
     *         "next_page_url": "http://localhost:8000/api/dealers?page=2",
     *         "path": "http://localhost:8000/api/dealers",
     *         "per_page": 15,
     *         "prev_page_url": null,
     *         "to": 15
     *     },
     *     "errors": {}
     * }
     */
    public function index()
    {
        $per_page = request()->per_page ?? 5;
        $page = request()->page ?? 1;

        $dealers = Dealer::with('district', 'district.state')->simplePaginate($per_page, ['*'], 'page', $page);

        return response()->json([
            'status' => true,
            'message' => 'Dealers',
            'data' => $dealers,
            'errors' => (object)[],
        ]);
    }

    /**
     * Submit a new dealer submission.
     *
     * @group Dealers
     * @post
     * @url /api/dealer/submit
     * @bodyParam name string required The name of the dealer.
     * @bodyParam mobile_number string required The mobile number of the dealer (10 digits).
     * @bodyParam email string optional The email address of the dealer (max 255 characters).
     * @bodyParam address string optional The address of the dealer (max 500 characters).
     * @bodyParam message string optional The message from the dealer (max 500 characters).
     *
     * @response 201 {
     *     "status": true,
     *     "message": "Dealer created successfully",
     *     "data": {
     *         "id": 1,
     *         "name": "John Doe",
     *         "mobile_number": "1234567890",
     *         "email": "johndoe@example.com",
     *         "address": "123 Main Street",
     *         "message": "Hello, I'm interested in your products."
     *     },
     *     "errors": {}
     * }
     *
     * @response 422 {
     *     "status": false,
     *     "message": "Validation failed",
     *     "data": {},
     *     "errors": {
     *         "name": ["The name field is required."],
     *         "mobile_number": ["The mobile number field is required."],
     *         // Additional validation errors
     *     }
     * }
     */
    public function submit(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|digits:10',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'message' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'data' => (object)[],
                'errors' => $validator->errors(),
            ]);
        }

        $dealer = DealerSubmission::create([
            'name' => $request->name,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'address' => $request->address,
            'message' => $request->message,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Dealer created successfully',
            'data' => $dealer,
            'errors' => (object)[],
        ]);
    }
}
