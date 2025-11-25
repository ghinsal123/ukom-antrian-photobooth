<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class OperatorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Contoh: cek role user
        if (auth()->check() && auth()->user()->role === 'operator') {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
