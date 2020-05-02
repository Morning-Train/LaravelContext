<?php

namespace MorningTrain\Laravel\Context;

use Illuminate\Support\ServiceProvider;
use MorningTrain\Laravel\Context\Events\ContextRegistered;
use MorningTrain\Laravel\Context\Events\ContextRegistering;

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

    public function boot(ContextService $context)
    {
        Event::dispatch(new ContextRegistering($context));
        $this->registerPlugins($context);
        $this->registerContexts($context);
        $this->loadFeatures($context);
        Event::dispatch(new ContextRegistered($context));
    }

    protected function registerPlugins(ContextService $context)
    {
        foreach ($this->plugins as $plugin) {
            $context->plugin($plugin);
        }
    }

    protected function registerContexts(ContextService $context)
    {
        foreach ($this->contexts as $name => $class) {
            $context->register($name, $class);
        }
    }

    protected function loadFeatures(ContextService $context)
    {
        foreach ($this->load as $feature) {
            $context->load($feature);
        }
    }

}
