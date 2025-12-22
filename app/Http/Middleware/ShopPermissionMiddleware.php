<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopPermissionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        if (auth()->user()->role === 'super_admin') {
            return $next($request);
        }

        if (!auth()->user()->shop_id) {
            abort(403, 'No shop assigned.');
        }

        return $next($request);
    }
}
