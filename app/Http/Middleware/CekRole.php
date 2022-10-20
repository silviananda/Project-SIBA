<?php

namespace App\Http\Middleware;

use Closure;

class CekRole
{
    public function handle($request, Closure $next,...$roles)
    {
        if (in_array($request->user()->role,$roles)){
            return $next($request);
        }

        return redirect('/');
    }
}
