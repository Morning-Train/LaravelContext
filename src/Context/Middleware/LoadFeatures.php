<?php

namespace MorningTrain\Laravel\Context\Middleware;

use \Closure;
use MorningTrain\Laravel\Context\Context;

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