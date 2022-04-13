<?php

namespace MorningTrain\Laravel\Context\Traits;

use MorningTrain\Laravel\Context\Plugins\Routes\Registrar;

trait HasRoutesContext
{
    protected static ?Registrar $routesRegistrar = null;

    protected static function getRoutesRegistrar(): Registrar
    {
        return static::$routesRegistrar ?: (static::$routesRegistrar = new Registrar());
    }

    public static function router(...$arguments): array
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

    public static function routes(...$arguments): void
    {
        static::getRoutesRegistrar()->addRoutes(...$arguments);
    }

}
