<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Waiter
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
        if(\App\Waiter::where('user_id',Auth::id())->first())
            return $next($request);
        else
        {
            return response()->json()->setStatusCode(401);
        }
    }
}
