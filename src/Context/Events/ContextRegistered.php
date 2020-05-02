<?php

namespace MorningTrain\Laravel\Context\Events;

class ContextRegistered
{

    public $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

}
