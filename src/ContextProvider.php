<?php

namespace MorningTrain\Laravel\Context;

/**
 * Class ContextProvider
 * @package MorningTrain\Laravel\Context
 */
class ContextProvider
{

    /**
     * @var array
     */
    protected $partials = [];


    /**
     * Load all context partials
     *
     * @return void
     */
    public function load()
    {
        if (is_array($this->partials) && !empty($this->partials)) {
            foreach ($this->partials as $partial) {
                Context::load($partial);
            }
        }
    }

    /**
     * Load the context and all its partials
     *
     * @return void
     */
    public function boot()
    {
        if (is_array($this->partials) && !empty($this->partials)) {
            foreach ($this->partials as $partial) {
                Context::boot($partial);
            }
        }
    }

}
