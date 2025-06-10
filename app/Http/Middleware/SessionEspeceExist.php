<?php

namespace App\Http\Middleware;

use Closure;

class SessionEspeceExist
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

        if(session()->get('espece_id') == null)
        {
          return redirect()->route('accueil');
        }
        return $next($request);
    }
}
