<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiAuthController extends Controller
{
    public function emailLogin()
    {
        // Validate the request...
        $credentials = request(['email', 'password']);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = auth()->user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}