<?php

namespace MorningTrain\Laravel\Context;

use Illuminate\Support\ServiceProvider;

class ContextServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $plugins = [];

    /**
     * @var array
     */
    protected $contexts = [];

    /**
     * @var array
     */
    protected $load = [];

    public function register()
    {
        $this->app->singleton(ContextService::class, function () {
            return new ContextService();
        });
    }

    public function boot()
    {
        $this->registerContexts();
        $this->loadFeatures();
    }

    protected function registerContexts()
    {
        foreach ($this->contexts as $name => $class) {
            Context::register($name, $class);
        }
    }

    protected function loadFeatures()
    {
        foreach ($this->load as $feature) {
            Context::load($feature);
        }
    }

}
