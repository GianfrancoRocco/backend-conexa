<?php

namespace App\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        /** @var array<string, mixed> */
        $data = $request->validated();

        User::create($data);

        /** @var string */
        $token = Auth::attempt($request->only('email', 'password'));

        return response()->json([
            'auth' => [
                'token' => $token,
                'type' => 'bearer'
            ]
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        /** @var array<string, mixed> */
        $data = $request->validated();

        $token = Auth::attempt($data);

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
