<?php

namespace MorningTrain\Laravel\Context\Traits;

use MorningTrain\Laravel\Context\Context;
use MorningTrain\Laravel\Context\Plugins\Routes\Registrar;

trait HasRoutesContext
{
    protected static ?Registrar $routesRegistrar = null;

    protected static function getRoutesRegistrar(): Registrar
    {
        return static::$routesRegistrar ?: (static::$routesRegistrar = new Registrar());
    }

    public static function getRouterData(): array
    {
        $currentRoute = app()->make('router')->getCurrentRoute();

        return [
            'baseUrl' => url(''),
            'currentUrl' => request()->fullUrl(),
            'currentRoute' => isset($currentRoute, $currentRoute->action['as']) ? $currentRoute->action['as'] : null,
            'currentParameters' => (object) array_merge($currentRoute->parameters, request()->query()),
            'routes' => static::getRoutesRegistrar()->getRoutesData()
        ];
    }

    public static function setRouterInEnv()
    {
        Context::env('router', function() {
            return Context::getRouterData();
        });
    }

    public static function routes(...$arguments): void
    {
        static::getRoutesRegistrar()->addRoutes(...$arguments);
    }

}
