<?php

namespace Nuclear\Reactor\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateApiToken
{
	/**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
    	$event->user->UpdateApiToken();
    }
}