<?php

namespace MorningTrain\Laravel\Context\Plugins\Assets;

use MorningTrain\Laravel\Context\ContextService;
use MorningTrain\Laravel\Context\Contracts\Pluginable;

class AssetsPlugin implements Pluginable
{

    /**
     * @var ScriptRegistrar
     */
    protected $scriptRegistrar;

    /**
     * @var StylesheetRegistrar
     */
    protected $stylesheetRegistrar;

    public function register(ContextService $context)
    {
        $context->extend('scripts', function (...$arguments) {
            if (empty($arguments)) {
                return $this->getScriptRegistrar();
            }

            return $this->getScriptRegistrar()->add(...$arguments);
        });

        $context->extend('stylesheets', function (...$arguments) {
            if (empty($arguments)) {
                return $this->getStylesheetRegistrar();
            }

            return $this->getStylesheetRegistrar()->add(...$arguments);
        });
    }

    protected function getScriptRegistrar()
    {
        return $this->scriptRegistrar ?: ($this->scriptRegistrar = new ScriptRegistrar());
    }

    protected function getStylesheetRegistrar()
    {
        return $this->stylesheetRegistrar ?: ($this->stylesheetRegistrar = new StylesheetRegistrar());
    }

}