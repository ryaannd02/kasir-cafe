<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KasirMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'kasir') {
            return $next($request);
        }

        return redirect('/login')->withErrors('Anda tidak punya akses sebagai kasir');
    }
}