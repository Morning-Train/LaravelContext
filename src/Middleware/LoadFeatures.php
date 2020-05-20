<?php

namespace MorningTrain\Laravel\Context\Middleware;

use Closure;
use Illuminate\Support\Facades\Event;
use MorningTrain\Laravel\Context\Context;
use MorningTrain\Laravel\Context\Events\ContextsBooted;
use MorningTrain\Laravel\Context\Events\ContextsBooting;

class LoadFeatures
{

    public function handle($request, Closure $next, ...$features)
    {

        Event::dispatch(new ContextsBooting());

        foreach ($features as $feature) {
            Context::load($feature);
        }

        Event::dispatch(new ContextsBooted());

        return $next($request);
    }

}
