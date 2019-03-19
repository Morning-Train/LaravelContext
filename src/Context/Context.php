<?php

namespace MorningTrain\LaravelContext;

use Illuminate\Support\Facades\Facade;

class Context extends Facade
{

    public static function getFacadeAccessor()
    {
        return ContextService::class;
    }

}