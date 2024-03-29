<?php

namespace MorningTrain\Laravel\Context\Plugins\Routes;

use Illuminate\Routing\Router;

class Registrar
{

    /**
     * @var array
     */
    protected $routes = [];

    /**
     * @var Router
     */
    protected $router;

    public function __construct()
    {
        $this->router = app()->make('router');
    }

    public function addRoutes($routes)
    {
        $this->routes = array_merge($this->routes, (array)$routes);
    }

    public function getRoutesData()
    {
        $routes = $this->router->getRoutes();
        $data = [];

        foreach ($routes as $route) {
            if (!isset($route->action['as'])) {
                continue;
            }

            foreach ($this->routes as $pattern) {
                if (fnmatch($pattern, $route->action['as'])) {

                    $compiledRoute = $route->getCompiled();

                    if(!$compiledRoute) {
                        try {
                            $compiledRoute = $route->toSymfonyRoute()->compile();
                        } catch (\Exception $e) {
                            $compiledRoute = null;
                        }
                    }

                    $data[$route->action['as']] = [
                        'name' => $route->action['as'],
                        'methods' => $route->methods,
                        'uri' => $route->uri,
                        'variables' => $compiledRoute ? $compiledRoute->getVariables():[]
                    ];
                }
            }
        }

        return $data;
    }

}
