<?php

namespace App\Http\Middleware;

use Closure;

class FrameHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Credentials', 'true');
        $response->header('Access-Control-Allow-Methods', 'GET,HEAD,OPTIONS,POST,PUT');
        $response->header('Access-Control-Allow-Headers', 'XMLHttpRequest, Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Authorization, Access-Control-Request-Method, Access-Control-Request-Headers');
        return $response;
    }
}
