<?php

namespace MorningTrain\Laravel\Context\Plugins\Store;

use MorningTrain\Laravel\Context\ContextService;
use MorningTrain\Laravel\Context\Contracts\Pluginable;
use MorningTrain\Laravel\Context\Plugins\Localization\LocalizationPlugin;

class StorePlugin implements Pluginable
{

    public function register(ContextService $context)
    {
        $context->plugin(LocalizationPlugin::class);

        $context->extend('store', function (... $arguments) use ($context) {
            return count($arguments) > 0 ? $this->getRegistrar()->provide(...$arguments) : $this->getRegistrar();
        });
    }

    /**
     * @var Registrar
     */
    protected $registrar;

    protected function getRegistrar()
    {
        return $this->registrar ?: ($this->registrar = new Registrar());
    }

}
