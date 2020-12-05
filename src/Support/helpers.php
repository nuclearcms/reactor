<?php

if (!function_exists('nuclear_version')) {
    /**
     * Returns the Nuclear Version
     *
     * @return string
     */
    function nuclear_version(array $attributes = [])
    {
        return \Nuclear\Reactor\Providers\ReactorServiceProvider::VERSION;
    }
}

if (!function_exists('is_installed'))
{
    /**
     * Checks if Nuclear is installed
     *
     * @return bool
     */
    function is_installed()
    {
        return ((env('APP_STATUS', 'INSTALLED') === 'INSTALLED') && ! empty(env('DB_DATABASE')));
    }
}

if (!function_exists('is_request_reactor'))
{
    /**
     * Checks if the request is a reactor request
     *
     * @return bool
     */
    function is_request_reactor()
    {
        return (request()->segment(1) === config('reactor.prefix'));
    }
}

if (!function_exists('is_request_install'))
{
    /**
     * Checks if the request is a reactor request
     *
     * @return bool
     */
    function is_request_install()
    {
        return (request()->segment(1) === 'install');
    }
}