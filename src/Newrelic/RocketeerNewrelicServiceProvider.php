<?php
namespace Rocketeer\Plugins\Newrelic;

use Illuminate\Support\ServiceProvider;
use Rocketeer\Facades\Rocketeer;

/**
 * Register the plugin with Rocketeer
 */
class RocketeerNewrelicServiceProvider extends ServiceProvider
{
    /**
     * Register classes
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Boot the plugin
     *
     * @return void
     */
    public function boot()
    {
        Rocketeer::plugin('Rocketeer\Plugins\Newrelic\RocketeerNewrelic');
    }
}