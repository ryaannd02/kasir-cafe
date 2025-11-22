<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ManajerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'manajer') {
            return $next($request);
        }

        return redirect('/login')->withErrors('Anda tidak punya akses sebagai manajer');
    }
}