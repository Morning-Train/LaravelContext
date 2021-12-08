<?php

namespace MorningTrain\Laravel\Context;

use Illuminate\Support\Facades\Facade;

/**
 * @method static meta(string $meta_key, mixed $meta_value) Sets meta value
 * @method static render(string $blade_view_name) Returns prefixed blade view
 * @method static view(string $blade_view_name) Returns prefixed blade view
 * @method static views() Returns prefixed blade view
 * @method static env(string|\Closure $env_path, mixed|\Closure $value)
 * @method static routes()
 * @method static scripts()
 * @method static stylesheets()
 * @method static menu()
 */
class Context extends Facade
{

    public static function getFacadeAccessor()
    {
        return ContextService::class;
    }

}
