<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Enums\UserRole;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

final class AuthController
{
    /**
     * Summary of register
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => UserRole::USER,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => UserResource::make($user),
        ], Response::HTTP_CREATED);
    }

    /**
     * Summary of login
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'error' => 'Email or password is incorrect',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => UserResource::make(Auth::user()),
        ], Response::HTTP_OK);
    }

    /**
     * Summary of logout
     */
    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'message' => 'Successfully logged out',
        ], Response::HTTP_OK);
    }

    /**
     * Summary of the current authed user
     */
    public function getUser(): JsonResponse
    {
        return response()->json([
            'message' => 'User profile retrieved successfully',
            'user' => UserResource::make(Auth::user()),
        ], Response::HTTP_OK);
    }

    /**
     * Summary of newly created token
     */
    public function refresh(): JsonResponse
    {
        $token = JWTAuth::refresh(JWTAuth::getToken());

        return response()->json([
            'message' => 'Token refreshed successfully',
            'token' => $token,
        ], Response::HTTP_OK);
    }
}
