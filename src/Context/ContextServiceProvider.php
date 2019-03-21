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
        $this->registerPlugins();
        $this->registerFeatures();
        $this->loadFeatures();
    }

    protected function registerPlugins()
    {
        foreach ($this->plugins as $plugin) {
            Context::plugin($plugin);
        }
    }

    protected function registerFeatures()
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
