<?php

namespace App\Http\Middleware;

use Closure;

class XFrameHeadersMiddleware
{
    /**
     * Allow video to be rendered from youtube.com.
     *
     * @param  $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('X-Frame-Options', 'ALLOW-FROM https://www.youtube.com');

        return $response;
    }
}
