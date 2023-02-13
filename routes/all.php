<?php

Route::domain(
    preg_replace(
        '#^[^:/.]*[:/]+#i', '',
        config('app.reactor_domain', null) ?: config('app.url'))
    )->group(function() {

    Route::group([
        'prefix' => config('reactor.prefix', 'reactor'),
        'middleware' => ['web', 'theme:' . config('themes.active_reactor', 'reactor')]
    ], function() {

        Route::name('reactor.')->group(function() {
            // Authentication and password resets
            Route::namespace('\Umomega\Auth\Http\Controllers')->group(function() {
                Auth::routes(['register' => false]);
            });

            // Authenticated SPA
            Route::group([
                'middleware' => ['auth.reactor', 'permission:superadmin|access_reactor'/*, 'password.confirm:reactor.password.confirm'*/],
                'namespace' => '\Nuclear\Reactor\Http\Controllers'
            ], function() {
                // All other
                Route::get('/{any?}', 'ReactorController@index')->name('main')->where('any', '.*');
            });
        });
    });

    // API Routes
    Route::group([
        'prefix' => 'api',
        'middleware' => [
            'api',
            'permission:superadmin|access_reactor',
            Nuclear\Reactor\Http\Middleware\SetReactorLocale::class
        ]
    ], function() {

        Route::name('api.')->group(function() {
            Route::middleware('auth:api')->group(function() {
                Route::namespace('Nuclear\Reactor\Http\Controllers')->group(function() {
                    require 'api/dashboard.php';
                    require 'api/maintenance.php';
                });

                Route::namespace('Umomega\Auth\Http\Controllers')->group(function() {
                    require 'api/profile.php';
                    require 'api/permissions.php';
                    require 'api/roles.php';
                    require 'api/users.php';
                });

                Route::namespace('Umomega\Media\Http\Controllers')->group(function() {
                    require 'api/media.php';
                });

                Route::namespace('Umomega\Tags\Http\Controllers')->group(function() {
                    require 'api/tags.php';
                });

                Route::namespace('Nuclear\Hierarchy\Http\Controllers')->group(function() {
                    require 'api/contenttypes.php';
                    require 'api/contentfields.php';
                    require 'api/contents.php';
                });

                Route::namespace('Umomega\Former\Http\Controllers')->group(function() {
                    require 'api/answers.php';
                    require 'api/forms.php';
                    require 'api/formfields.php';
                });
            });
        });
    });

    // Utilities
    Route::group([
        'prefix' => '_utilities',
        'namespace' => 'Umomega\Foundation\Http\Controllers'
    ], function() {
        Route::name('utilities.')->group(function() {
            Route::get('translations/lang-{locale}.js', 'UtilitiesController@localization')->name('translations');
        });
    });

});
