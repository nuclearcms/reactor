<?php

namespace Nuclear\Reactor\Providers;

use App\Providers\TelescopeServiceProvider;
use Illuminate\Support\ServiceProvider;

class ReactorServiceProvider extends ServiceProvider
{

    /**
     * Nuclear Version
     */
    const VERSION = '4.0-alpha.0';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/reactor.php', 'reactor'
        );

        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->register(ReactorEventServiceProvider::class);

        require_once(__DIR__ . '/../Support/helpers.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/reactor.php' => config_path('reactor.php')], 'config');

        $this->publishes([__DIR__ . '/../../resources/lang' => resource_path('lang/vendor/reactor')], 'lang');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'reactor');

        $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/reactor')], 'views');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'reactor');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/all.php');

        \View::composer('reactor::app', function($view) {
            $view->with('user', auth()->user());
        });
    }
}
