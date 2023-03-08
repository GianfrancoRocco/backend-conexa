<?php

namespace App\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $token = Auth::attempt($request->validated());

        if (!$token) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'auth' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ]);
    }
}
