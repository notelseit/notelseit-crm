<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $key = $request->header('X-Admin-Key');
        if ($key !== 'fanculo2025') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return $next($request);
    }
}