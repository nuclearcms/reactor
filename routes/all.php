<?php

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
    'middleware' => ['api', 'permission:superadmin|access_reactor']
], function() {

    Route::name('api.')->group(function() {
        Route::middleware('auth:api')->group(function() {
            require_once 'api/dashboard.php';

            Route::namespace('Umomega\Auth\Http\Controllers')->group(function() {
                require_once 'api/profile.php';
                require_once 'api/permissions.php';
                require_once 'api/roles.php';
                require_once 'api/users.php';
            });

            Route::namespace('Umomega\Media\Http\Controllers')->group(function() {
                require_once 'api/media.php';
            });

            Route::namespace('Umomega\Tags\Http\Controllers')->group(function() {
                require_once 'api/tags.php';
            });

            Route::namespace('Nuclear\Hierarchy\Http\Controllers')->group(function() {
                require_once 'api/contenttypes.php';
                require_once 'api/contentfields.php';
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
