<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtAdminMiddleware
{
    /**
     * Summary of the admin jwt
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user) {
                return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            if ($user->role !== UserRole::ADMIN) {
                return response()->json(['error' => 'Forbidden - Admin access required'], Response::HTTP_FORBIDDEN);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
