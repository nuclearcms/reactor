<?php

namespace Nuclear\Reactor\Providers;

use App\Providers\TelescopeServiceProvider;
use Illuminate\Support\ServiceProvider;

class ReactorServiceProvider extends ServiceProvider
{

    /**
     * Nuclear Version
     */
    const VERSION = '4.0.4';

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

        require(__DIR__ . '/../Support/helpers.php');

        $this->app->singleton('Nuclear\Reactor\Support\TokenManager', function($app) {
            return $app->make('\Nuclear\Reactor\Support\TokenManager');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            \Nuclear\Reactor\Console\GenerateSitemap::class,
        ]);

        $this->publishes([__DIR__ . '/../../config/reactor.php' => config_path('reactor.php')], 'config');

        $this->publishes([__DIR__ . '/../../resources/lang' => resource_path('lang/vendor/reactor')], 'lang');
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'reactor');

        $this->publishes([__DIR__ . '/../../resources/views' => resource_path('views/vendor/reactor')], 'views');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'reactor');

        $this->publishes([__DIR__ . '/../../public' => public_path('vendor/app')], 'public');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/all.php');

        \View::composer('reactor::app', function($view) {
            $view->with('user', auth()->user());
        });
    }
}
