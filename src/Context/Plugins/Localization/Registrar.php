<?php

namespace MorningTrain\Laravel\Context\Plugins\Localization;

use Closure;

class Registrar
{

    /**
     * @var array
     */
    protected $localization = [];

    /**
     * @var array
     */
    protected $providers = [];

    /**
     * @var bool
     */
    protected $providersWerePublished = false;

    public function localize($namespace, $data = null)
    {
        if (is_array($namespace)) {
            $localization = $namespace;
        } else if (is_string($namespace) && (strlen($namespace) > 0)) {
            $localization = [];
            $current = &$localization;
            $path = explode('.', $namespace);

            do {
                $key = array_shift($path);
                $current[$key] = count($path) > 0 ? [] : $data;
                $current = &$current[$key];
            } while (count($path) > 0);
        } else {
            $localization = $data;
        }

        if (isset($localization)) {
            $this->localization = array_merge_recursive($this->localization, $localization);
        }

        return $this;
    }

    public function provide($namespace, Closure $provider = null)
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
                    $this->localize($namespace, $provider());
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

    public function data()
    {
        $this->publishProviders();
        return $this->localization;
    }

    public function __toString()
    {
        $localization = $this->data();
        $html = '';

        if (!empty($localization)) {
            $html .= '<script>';

            foreach ($localization as $key => $value) {
                $html .= "window.{$key}=" . json_encode($value) . ';';
            }

            $html .= '</script>';
        }

        return $html;
    }

}
