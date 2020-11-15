<?php

namespace Nuclear\Reactor\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Nuclear\Reactor\Listeners\UpdateApiToken;

class ReactorEventServiceProvider extends ServiceProvider
{

	/**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Login::class => [
            UpdateApiToken::class,
        ],
    ];

}