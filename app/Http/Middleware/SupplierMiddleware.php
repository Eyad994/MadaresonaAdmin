<?php

namespace App\Http\Middleware;

use Closure;

class SupplierMiddleware
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
        if ($request->user() && $request->user()->type != 1 && auth()->user()->type != 4 ) {
            abort(403);
        }
        return $next($request);
    }
}
