<?php

namespace MorningTrain\Laravel\Context\Plugins\Env;

use MorningTrain\Laravel\Context\ContextService;
use MorningTrain\Laravel\Context\Contracts\Pluginable;

class EnvPlugin implements Pluginable
{

    protected $registrar;

    public function register(ContextService $context)
    {
        $context->extend('env', function ($key = null, $value = null) {

            if ($key !== null && $value === null) {
                $value = $key;
                $key = 'env';
            }

            if ($key === null && $value === null) {
                return $this->getRegistrar()->data();
            }

            if ($key !== 'env') {
                $key = 'env.' . $key;
            }

            return $this->getRegistrar()->set($key, $value);
        });
    }

    protected function getRegistrar()
    {
        return $this->registrar ?: ($this->registrar = new Registrar());
    }

}
