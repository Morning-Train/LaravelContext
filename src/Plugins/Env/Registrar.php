<?php

namespace MorningTrain\Laravel\Context\Plugins\Env;

use Closure;
use Illuminate\Support\Arr;

class Registrar
{

    /**
     * @var array
     */
    protected $env = [];

    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var bool
     */
    protected $providersWerePublished = false;

    public function set($namespace, $data = null)
    {

        if($data instanceof Closure){
            return $this->setProvider($namespace, $data);
        }

        if (is_array($namespace)) {
            $env = $namespace;
        } else if (is_string($namespace) && (strlen($namespace) > 0)) {
            $env = [];
            $current = &$env;
            $path = explode('.', $namespace);

            do {
                $key = array_shift($path);
                $current[$key] = count($path) > 0 ? [] : $data;
                $current = &$current[$key];
            } while (count($path) > 0);
        } else {
            $env = $data;
        }

        if (isset($env)) {
            $this->env = $this->array_merge_recursive_distinct($this->env, $env);
        }

        return $this;
    }


    protected function array_merge_recursive_distinct(array &$array1, array &$array2)
    {
        $merged = $array1;
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->array_merge_recursive_distinct($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    public function setProvider($namespace, $provider = null)
    {
        if ($namespace instanceof Closure) {
            $provider = $namespace;
            $namespace = '';
        }

        if (!isset($this->providers[$namespace])) {
            $this->providers[$namespace] = [];
        }

        $this->providers[$namespace][] = $provider;

        return $this;
    }

    protected function publishProviders()
    {
        if ($this->providersWerePublished) {
            return;
        }

        foreach ($this->providers as $namespace => $providers) {
            foreach ($providers as $provider) {
                try {
                    $this->set($namespace, $provider());
                } catch (\Exception $exception) {
                    if(function_exists('report')) {
                        report($exception);
                    }
                    if(app()->isLocal()) {
                        dd($exception);
                    }
                }
            }
        }

        $this->providersWerePublished = true;
    }

    public function __toString()
    {

        $env = $this->data();

        $html = '';

        if (!empty($env)) {
            $html .= '<script>';

            foreach ($env as $key => $value) {
                $html .= "window.{$key}=" . json_encode($value) . ';';
            }

            $html .= '</script>';
        }

        return $html;
    }

    public function data()
    {
        if(function_exists('debugbar')) {
            debugbar()->measure("Building ENV from providers", function() {
                $this->publishProviders();
            });
        } else {
            $this->publishProviders();
        }

        return $this->env;
    }

}
