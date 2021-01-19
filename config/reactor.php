<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The Prefix For All Reactor Routes
    |--------------------------------------------------------------------------
    */
    'prefix' => env('REACTOR_PREFIX', 'reactor'),

	/*
    |--------------------------------------------------------------------------
    | Reactor Locale
    |--------------------------------------------------------------------------
    */
    'locale' => env('REACTOR_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Locale Keywords For Loading Translations
    |--------------------------------------------------------------------------
    */

    'locale-keywords' => ['reactor::general', 'foundation::general', 'foundation::errors', 'validation', 'auth::auth', 'auth::users', 'auth::permissions', 'auth::roles', 'auth::events', 'tags::tags', 'media::media', 'hierarchy::contenttypes', 'hierarchy::contentfields', 'hierarchy::contents', 'former::forms', 'former::fields', 'former::answers'],
    
];
