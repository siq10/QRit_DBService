<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class Authorize
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
        if(Auth::user())
        {

            $response =  $next($request);

            $response->headers->set('Authorization', 'Bearer '.$request->bearerToken());
            return $response;
        }
        else
        {
            $unprotectedRoutes = ["api/users",
                "api/authentication"];
            if(in_array($request->path(),$unprotectedRoutes) )
            {
                $response =  $next($request);
                return $response;
            }
            else
            {
                return response()->json()->setStatusCode(401);
            }
        }
    }
}
