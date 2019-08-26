<?php

namespace MorningTrain\Laravel\Context\Plugins\Store;

use Illuminate\Routing\Router;
use MorningTrain\Laravel\Context\Context;

class Registrar
{

    /**
     * @var array
     */
    protected $sources = [];

    /**
     * @var Router
     */
    protected $router;

    public function __construct()
    {
        $this->router = app()->make('router');
    }

    public function from($menus)
    {
        $this->sources = (array)$menus;
        return $this;
    }

    protected function getRoutePath(string $route, array $items, array $path = [])
    {
        foreach ($items as $item) {
            if ($item->type === 'item') {
                if ($item->route === $route) {
                    $path[] = (object)[
                        'route' => $item->route,
                        'url' => $item->url,
                        'title' => $item->title
                    ];

                    return $path;
                }

            } else if ($item->type === 'group') {
                $groupPath = $this->getRoutePath($route, $item->items, [
                    (object)[
                        'route' => $item->route,
                        'url' => $item->url,
                        'title' => $item->title
                    ]
                ]);

                if ($groupPath) {
                    return $groupPath;
                }
            }
        }
    }

    public function items()
    {
        $currentRoute = $this->router->getCurrentRoute();

        if (is_null($currentRoute)) {
            return collect();
        }

        foreach ($this->sources as $menuName) {
            if ($crumbs = $this->getRoutePath($currentRoute->action['as'], Context::menu($menuName)->items()->all())) {
                return collect($crumbs);
            }
        }

        return collect();
    }

}