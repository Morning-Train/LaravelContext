<?php

namespace MorningTrain\LaravelContext\Middleware;

use \Closure;
use MorningTrain\LaravelContext\Context;

class LoadFeatures
{

    public function handle($request, Closure $next, ...$features)
    {
        foreach ($features as $feature) {
            Context::load($feature);
        }

        return $next($request);
    }

}