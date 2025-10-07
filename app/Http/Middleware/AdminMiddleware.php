<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Allow both admin and staff accounts to access admin area
        $user = auth()->user();
        if (! ($user->isAdmin() || (method_exists($user, 'isStaff') && $user->isStaff())) ) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
