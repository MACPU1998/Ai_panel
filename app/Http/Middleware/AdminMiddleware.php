<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();


        if (!$user || !($user instanceof \App\Models\Admin)) {
            return response()->json(['message' => 'Unauthorized (Admin)'], 403);
        }

        $hasUserRole = $user->roles()->where('name', 'super admin')->where('guard_name', 'admin')->exists();

        if (!$hasUserRole) {
            return response()->json(['message' => 'You do not have the necessary access.'], 403);
        }

        return $next($request);
    }
}
