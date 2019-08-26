<?php

namespace MorningTrain\Laravel\Context\Plugins\Menus;

use \Closure;

class Menu
{

    protected $items = [];

    protected function route($route)
    {
        if (is_string($route)) {
            return route($route);
        }

        if (is_array($route)) {
            $args = array_slice($route, 1);
            $route = array_shift($route);

            return route($route, $args);
        }

        return '#';
    }

    public function item(string $title, $route = null, array $options = [])
    {
        $item = array_merge([
            'type' => 'item',
            'title' => $title,
            'route' => $route,
            'url' => $this->route($route)

        ], $options);

        $this->items[] = (object)$item;

        return $this;
    }

    public function group(string $title, $route, Closure $group, array $options = [])
    {
        $children = new Menu();
        $group($children);

        return $this->item($title, $route, array_merge([
            'type' => 'group',
            'items' => $children->items()

        ], $options));
    }

    public function items()
    {
        return collect($this->items);
    }

    public function rootItems()
    {
        return $this->items()->map(function ($item) {
            $item = clone $item;
            $item->items = [];
            return $item;
        });
    }

}
