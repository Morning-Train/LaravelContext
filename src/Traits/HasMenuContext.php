<?php

namespace MorningTrain\Laravel\Context\Traits;

use MorningTrain\Laravel\Context\Plugins\Menus\Menu;

trait HasMenuContext
{

    protected static array $menus = [];

    public static function menu(string $name, \Closure $callback = null)
    {
        if(!isset(static::$menus[$name])) {
            static::$menus[$name] = new Menu();
        }

        if ($callback instanceof \Closure) {
            $callback(static::$menus[$name]);
        }

        return static::$menus[$name];
    }

}
