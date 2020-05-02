<?php

namespace MorningTrain\Laravel\Context\Events;

class ContextRegistering
{

    public $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

}
