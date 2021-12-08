<?php

namespace MorningTrain\Laravel\Context\Traits;

use MorningTrain\Laravel\Context\Plugins\Assets\ScriptRegistrar;
use MorningTrain\Laravel\Context\Plugins\Assets\StylesheetRegistrar;

trait HasAssetsContext
{

    /**
     * @var ScriptRegistrar
     */
    protected static $scriptRegistrar;

    /**
     * @var StylesheetRegistrar
     */
    protected static $stylesheetRegistrar;


    protected static function getScriptRegistrar()
    {
        return static::$scriptRegistrar ?: (static::$scriptRegistrar = new ScriptRegistrar());
    }

    protected static function getStylesheetRegistrar()
    {
        return static::$stylesheetRegistrar ?: (static::$stylesheetRegistrar = new StylesheetRegistrar());
    }

    public static function scripts(...$arguments)
    {
        if (empty($arguments)) {
            return static::getScriptRegistrar();
        }

        return static::getScriptRegistrar()->add(...$arguments);
    }

    public static function stylesheets(...$arguments)
    {
        if (empty($arguments)) {
            return static::getStylesheetRegistrar();
        }

        return static::getStylesheetRegistrar()->add(...$arguments);
    }

}