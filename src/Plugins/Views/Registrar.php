<?php

namespace MorningTrain\Laravel\Context\Plugins\Views;

class Registrar
{

    protected $prefix;

    public function prefix(string $prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function from(string $namespace)
    {
        return $this->prefix("{$namespace}.");
    }

    public function view(string $name)
    {
        return "{$this->prefix}{$name}";
    }

}