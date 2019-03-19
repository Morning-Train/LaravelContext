<?php

namespace MorningTrain\LaravelContext\Plugins\Localization;

use MorningTrain\LaravelContext\ContextService;
use MorningTrain\LaravelContext\Contracts\Pluginable;

class LocalizationPlugin implements Pluginable
{

    protected $registrar;

    public function register(ContextService $context)
    {
        $context->extend('localization', function () {
            return $this->getRegistrar();
        });

        $context->extend('localize', function (...$arguments) {
            return $this->getRegistrar()->localize(...$arguments);
        });
    }

    protected function getRegistrar()
    {
        return $this->registrar ?: ($this->registrar = new Registrar());
    }

}