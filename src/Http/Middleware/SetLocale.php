<?php

namespace Nuclear\Reactor\Http\Middleware;

use Closure;
use CodeZero\LocalizedRoutes\LocaleHandler;
use CodeZero\LocalizedRoutes\Middleware\SetLocale as BaseSetLocale;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class SetLocale extends BaseSetLocale
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(is_request_reactor()) return $next($request);
        // This package sets a custom route attribute for the locale.
        // If it is present, use this as the locale.
        $locale = $request->route()->getAction('localized-routes-locale')
            ?: $this->getLocaleFromFallbackRoute($request);

        App::make(LocaleHandler::class)->handleLocale($locale);
        
        // This bit is added later on
        Carbon::setLocale($locale);
        setlocale(LC_TIME, config('localized-routes.full_locales.' . $locale));

        return $next($request);
    }

}