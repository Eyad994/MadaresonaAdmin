<?php

namespace App\Http\Middleware;

use Closure;

class EditorMiddleware
{
    protected $user;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->user = auth()->user();
        if ($this->user->type != 1 && $this->user->type != 3 ) {
           abort(403);
        }
        return $next($request);
    }
}
