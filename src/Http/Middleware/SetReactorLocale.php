<?php

namespace Nuclear\Reactor\Http\Middleware;

use Closure;
use Carbon\Carbon;

class SetReactorLocale
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
        $locale = $request->user()->locale;
        app()->setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }

}
