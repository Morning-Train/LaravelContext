<?php

namespace MorningTrain\Laravel\Context\Contracts;

use MorningTrain\Laravel\Context\ContextService;

interface Pluginable
{

    public function register(ContextService $context);

}