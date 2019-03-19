<?php

namespace MorningTrain\LaravelContext\Plugins\Views;

use MorningTrain\LaravelContext\ContextService;
use MorningTrain\LaravelContext\Contracts\Pluginable;

class ViewsPlugin implements Pluginable
{

    public function register(ContextService $context)
    {
        $context->extend('views', function () {
            return $this->getRegistrar();
        });

        $context->extend('view', function (...$arguments) {
            return $this->getRegistrar()->view(...$arguments);
        });

        $context->extend('render', function (...$arguments) {
            return view($this->getRegistrar()->view(...$arguments));
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