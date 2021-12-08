<?php

namespace MorningTrain\Laravel\Context\Traits;

use MorningTrain\Laravel\Context\Plugins\Env\Registrar;

trait HasEnvContext
{

    protected static $envRegistar;

    protected static function getEnvRegistrar(): Registrar
    {
        return static::$envRegistar ?: (static::$envRegistar = new Registrar());
    }

    public static function env($key = null, $value = null)
    {
        if ($key !== null && $value === null) {
            $value = $key;
            $key = 'env';
        }

        if ($key === null && $value === null) {
            return static::getEnvRegistrar();
        }

        if ($key !== 'env') {
            $key = 'env.' . $key;
        }

        return static::getEnvRegistrar()->set($key, $value);
    }

}