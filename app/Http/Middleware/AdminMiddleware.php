<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak!');
        }

        // Share user admin ke semua blade
        view()->share('admin', auth()->user());

        return $next($request);
    }
}
