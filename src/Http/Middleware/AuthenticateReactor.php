<?php

namespace Nuclear\Reactor\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateReactor extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson() && $request->is(config('reactor.prefix', 'reactor') . '*')) {
            return route('reactor.login');
        }
    }
}
