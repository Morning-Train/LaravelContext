<?php

namespace MorningTrain\Laravel\Context\Traits;

use MorningTrain\Laravel\Context\Plugins\Views\Registrar;

trait HasViewsContext
{

    protected static Registrar $viewsRegistrar;

    protected static function getViewsRegistrar(): Registrar
    {
        return static::$viewsRegistrar ?: (static::$viewsRegistrar = new Registrar());
    }

    public static function views()
    {
        return static::getViewsRegistrar();
    }

    public static function view(...$arguments)
    {
        return static::getViewsRegistrar()->view(...$arguments);
    }

    public static function render(...$arguments)
    {
        return view(static::getViewsRegistrar()->view(...$arguments));
    }

}
