<?php

namespace MorningTrain\Laravel\Context;

/**
 * Class ContextProvider
 * @package MorningTrain\Laravel\Context
 */
class ContextProvider
{

    /**
     * @var ContextService
     */
    protected $context;

    /**
     * @var array
     */
    public static $plugins = [];

    /**
     * @var array
     */
    protected $partials = [];

    /**
     * ContextProvider constructor.
     */
    public function __construct(ContextService $context)
    {
        $this->context = $context;
    }

    /**
     * Proxy calls to the context service
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return $this->context->{$name}(...$arguments);
    }

    /**
     * Register all plugins in the context service
     *
     * @return void
     */
    protected function registerPlugins()
    {

        $plugins = static::$plugins;

        if (is_array($this->partials) && !empty($this->partials)) {
            foreach ($this->partials as $partial_class) {
                if (isset($partial_class::$plugins)) {
                    $plugins = array_merge($plugins, $partial_class::$plugins);
                }
            }
        }

        if (is_array($plugins) && !empty($plugins)) {
            foreach ($plugins as $plugin) {
                $this->context->plugin($plugin);
            }
        }

    }

    /**
     * Load all context partials
     *
     * @return void
     */
    public function load()
    {
        $this->registerPlugins();

        if (is_array($this->partials) && !empty($this->partials)) {
            foreach ($this->partials as $partial) {
                $this->context->load($partial);
            }
        }
    }

    /**
     * Load the context and all its partials
     *
     * @return void
     */
    public function boot()
    {
        if (is_array($this->partials) && !empty($this->partials)) {
            foreach ($this->partials as $partial) {
                $this->context->boot($partial);
            }
        }
    }

}
