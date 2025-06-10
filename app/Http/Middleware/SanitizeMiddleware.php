<?php

namespace App\Http\Middleware;

use Closure;

class SanitizeMiddleware
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
      foreach ($request->input() as $key => $value) {
        // if (empty($value)) {
        $request->request->set($key, floatval($value));
        // }
      }

      return $next($request);
    }
}
