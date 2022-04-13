<?php

namespace MorningTrain\Laravel\Context\Traits;

use MorningTrain\Laravel\Context\Plugins\Meta\Registrar;

trait HasMetaContext
{
    protected static Registrar $metaRegistrar;

    protected static function getMetaRegistrar(): Registrar
    {
        return static::$metaRegistrar ?: (static::$metaRegistrar = new Registrar());
    }

    public static function meta(...$arguments): Registrar
    {
        if (count($arguments) === 0) {
            return static::getMetaRegistrar();
        }

        if ((count($arguments) === 1) && !is_array($arguments[0])) {
            return static::getMetaRegistrar()->get(...$arguments);
        }

        return static::getMetaRegistrar()->set(...$arguments);
    }

}
