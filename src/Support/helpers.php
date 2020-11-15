<?php

if (! function_exists('nuclear_version')) {
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
