<?php

namespace MorningTrain\Laravel\Context\Plugins\Breadcrumbs;

use MorningTrain\Laravel\Context\ContextService;
use MorningTrain\Laravel\Context\Contracts\Pluginable;
use MorningTrain\Laravel\Context\Plugins\Menus\MenusPlugin;

class BreadcrumbsPlugin implements Pluginable
{

    public function register(ContextService $context)
    {
        // Dependencies
        $context->plugin(MenusPlugin::class);

        // Extension
        $context->extend('breadcrumbs', function () {
            return $this->getRegistrar();
        });

    }

    protected $registrar;

    protected function getRegistrar()
    {
        return $this->registrar ?: ($this->registrar = new Registrar());
    }

}

