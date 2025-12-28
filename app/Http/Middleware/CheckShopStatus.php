<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckShopStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Super admin is always allowed
            if ($user->role === 'super_admin') {
                return $next($request);
            }

            // Check if shop is active
            if ($user->shop_id && (!$user->shop || !$user->shop->is_active)) {
                Auth::logout();
                
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Your shop account is currently disabled.'], 403);
                }

                return redirect()->route('login')->withErrors(['email' => 'Your shop account is currently disabled. Please contact the administrator.']);
            }
        }

        return $next($request);
    }
}
