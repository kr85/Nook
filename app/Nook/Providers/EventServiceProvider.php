<?php namespace Nook\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EventServiceProvider
 *
 * @package Nook\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * Register Nook event listeners.
     */
    public function register()
    {
        $this->app['events']->listen('Nook.*', 'Nook\Handlers\EmailNotifier');
    }
}