<?php

namespace App\Http\Middleware;

use Closure;

class XFrameHeadersMiddleware
{

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', env('X_FRAME_OPTIONS'));

        return $response;
    }
}
