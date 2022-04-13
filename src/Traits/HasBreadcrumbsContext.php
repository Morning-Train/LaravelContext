<?php

namespace MorningTrain\Laravel\Context\Traits;

use MorningTrain\Laravel\Context\Plugins\Breadcrumbs\Registrar;

trait HasBreadcrumbsContext
{

    protected static Registrar $breadcrumbsRegistrar;

    protected static function getBreadcrumbsRegistrar(): Registrar
    {
        return static::$breadcrumbsRegistrar ?: (static::$breadcrumbsRegistrar = new Registrar());
    }

    public static function breadcrumbs(): Registrar
    {
        return static::getBreadcrumbsRegistrar();
    }

}
