<?php

namespace App\Http\Middleware;

use App\Facades\Instagram;
use Closure;
use Illuminate\Support\Facades\Auth;

class InstagramMiddleware
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
        if(auth()->user()->instagram){
            Instagram::setAccessToken(auth()->user()->instagram->access_token);
        }
        
        return $next($request);
    }
}
