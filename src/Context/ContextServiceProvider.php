<?php

namespace MorningTrain\LaravelContext;

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

    public function boot(ContextService $context)
    {
        $this->registerPlugins($context);
        $this->registerFeatures($context);
        $this->loadFeatures($context);
    }

    protected function registerPlugins(ContextService $context)
    {
        foreach ($this->plugins as $plugin) {
            $context->plugin($plugin);
        }
    }

    protected function registerFeatures(ContextService $context)
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