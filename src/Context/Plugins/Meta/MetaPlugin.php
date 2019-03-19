<?php

namespace MorningTrain\LaravelContext\Plugins\Meta;

use MorningTrain\LaravelContext\ContextService;
use MorningTrain\LaravelContext\Contracts\Pluginable;

class MetaPlugin implements Pluginable
{

    public function register(ContextService $context)
    {
        $context->extend('meta', function (...$arguments) {
            if (count($arguments) === 0) {
                return $this->getRegistrar();
            }

            if ((count($arguments) === 1) && !is_array($arguments[0])) {
                return $this->getRegistrar()->get(...$arguments);
            }

            return $this->getRegistrar()->set(...$arguments);
        });
    }

    protected $registrar;

    protected function getRegistrar()
    {
        return $this->registrar ?: ($this->registrar = new Registrar());
    }

}