<?php

namespace MorningTrain\Laravel\Context\Middleware;

use Closure;
use Illuminate\Support\Facades\Event;
use MorningTrain\Laravel\Context\Context;
use MorningTrain\Laravel\Context\Events\ContextsBooted;
use MorningTrain\Laravel\Context\Events\ContextsBooting;

class LoadContexts
{

    public function handle($request, Closure $next, ...$features)
    {

        foreach ($features as $feature) {
            Context::load($feature);
        }

        Event::dispatch(new ContextsBooting());

        Context::boot();

        Event::dispatch(new ContextsBooted());

        return $next($request);
    }

}
