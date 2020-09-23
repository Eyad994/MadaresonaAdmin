<?php

namespace App\Http\Middleware;

use Closure;

class SchoolMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->type != 1 && auth()->user()->type != 5 && auth()->user()->type != 3  ) {
            abort(403);
        }
        return $next($request);
    }
}
