<?php

namespace MorningTrain\LaravelContext\Contracts;

use MorningTrain\LaravelContext\ContextService;

interface Pluginable
{

    public function register(ContextService $context);

}