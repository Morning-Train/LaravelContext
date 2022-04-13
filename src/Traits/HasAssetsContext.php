<?php

namespace MorningTrain\Laravel\Context\Traits;

use MorningTrain\Laravel\Context\Plugins\Assets\ScriptRegistrar;
use MorningTrain\Laravel\Context\Plugins\Assets\StylesheetRegistrar;

trait HasAssetsContext
{

    protected static ?ScriptRegistrar $scriptRegistrar = null;
    protected static ?StylesheetRegistrar $stylesheetRegistrar = null;

    protected static function getScriptRegistrar(): ScriptRegistrar
    {
        return static::$scriptRegistrar ?: (static::$scriptRegistrar = new ScriptRegistrar());
    }

    protected static function getStylesheetRegistrar(): StylesheetRegistrar
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
