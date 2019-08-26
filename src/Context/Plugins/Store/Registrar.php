<?php

namespace MorningTrain\Laravel\Context\Plugins\Store;

use MorningTrain\Laravel\Context\Context;

class Registrar
{

    protected $namespace;

    public function __construct()
    {
        $this->namespace = 'store';
    }

    public function namespace(string $namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function provide(string $key, \Closure $provider)
    {
        Context::localization()->provide("{$this->namespace}.{$key}", $provider);
        return $this;
    }
}
