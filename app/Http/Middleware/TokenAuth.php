<?php

namespace App\Http\Middleware;

use Closure;

class TokenAuth
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
        //check request for certain header
        //if that header is not available, stop the request
        $token = $request->header('X-API-TOKEN');
        if ('test-value' != $token) {
            abort(401, 'Auth Token not found');
        }
        return $next($request);
    }
}
