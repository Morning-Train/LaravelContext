<?php

namespace MorningTrain\Laravel\Context\Events;

class ContextLoaded
{

    public $name;
    public $context;

    public function __construct($name, $context)
    {
        $this->name = $name;
        $this->context = $context;
    }

}
