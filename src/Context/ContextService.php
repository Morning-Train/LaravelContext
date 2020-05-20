<?php

namespace MorningTrain\Laravel\Context;

use Closure;
use Exception;
use Illuminate\Support\Facades\Event;
use MorningTrain\Laravel\Context\Events\ContextLoaded;
use MorningTrain\Laravel\Context\Events\ContextLoading;

class ContextService
{

    /**
     * @var array
     */
    protected $loaded = [];

    /**
     * @var array
     */
    protected $loaded_features = [];

    /**
     * @var array
     */
    protected $features = [];

    /**
     * @var array
     */
    protected $extensions = [];

    /**
     * @var array
     */
    protected $plugins = [];

    protected function featureExists($name)
    {
        return isset($this->features[$name]);
    }

    protected function getFeatureClass($name)
    {
        return $this->features[$name];
    }

    public function is($name)
    {
        return in_array($name, $this->loaded);
    }

    public function register(string $name, string $class)
    {
        $this->features[$name] = $class;
        return $this;
    }

    public function load($name)
    {
        $class = null;
        $is_feature = false;

        if (!$this->featureExists($name)) {
            // Check if class
            if (class_exists($name)) {
                $class = $name;
            }
        } else {
            $class = $this->getFeatureClass($name);
            $is_feature = true;
        }

        if (is_null($class)) {
            throw new Exception(sprintf('Context feature `%s` is not defined.', $name));
        }

        $feature = new $class($this);

        if (method_exists($feature, 'load')) {
            $feature->load();
        }

        $this->loaded[] = $name;
        $this->loaded_features[$class] = $feature;

        return $this;
    }

    public function boot($feature_class = null)
    {
        if($feature_class !== null) {
            if (is_array($this->loaded_features) && isset($this->loaded_features[$feature_class])) {
                $feature = $this->loaded_features[$feature_class];
                if (method_exists($feature, 'boot')) {
                    $feature->boot();
                }
            }

            return;
        }

        if (is_array($this->loaded_features) && !empty($this->loaded_features)) {
            foreach ($this->loaded_features as $feature) {
                if (method_exists($feature, 'boot')) {
                    $feature->boot();
                }
            }
        }
    }

    public function extend(string $methodName, Closure $method)
    {
        if (method_exists($this, $methodName)) {
            throw new Exception(sprintf('Context method `%s` is reserved.', $methodName));
        }

        $this->extensions[$methodName] = $method;
        return $this;
    }

    public function __call($name, $arguments)
    {
        if (!isset($this->extensions[$name])) {
            throw new Exception(sprintf('Context extension `%s` is not defined.', $name));
        }

        return $this->extensions[$name] (...$arguments);
    }

    public function plugin(string $class)
    {
        if (!isset($this->plugins[$class])) {
            $plugin = $this->plugins[$class] = new $class;

            if (method_exists($plugin, 'register')) {
                $plugin->register($this);
            }
        }

        return $this;
    }
}
