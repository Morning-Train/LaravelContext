<?php

namespace MorningTrain\Laravel\Context\Events;

class ContextRegistered
{

    public $context;

    public function __construct()
    {
        $this->context = $context;
    }

}
