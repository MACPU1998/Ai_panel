<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // بررسی اینکه آیا ادمین وارد شده است یا خیر
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }
        // dd('error');
        return redirect()->route('login');
    }
}
