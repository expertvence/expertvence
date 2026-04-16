<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth('api')->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = auth('api')->user();

        if ($user->role !== 'super_admin') {
            return response()->json(['message' => 'Forbidden. Super Admin access required.'], 403);
        }

        return $next($request);
    }
}
