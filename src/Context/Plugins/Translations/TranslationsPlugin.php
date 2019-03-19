<?php

namespace MorningTrain\Laravel\Context\Plugins\Translations;

use MorningTrain\Laravel\Context\Context;
use MorningTrain\Laravel\Context\ContextService;
use MorningTrain\Laravel\Context\Contracts\Pluginable;
use MorningTrain\Laravel\Context\Plugins\Localization\LocalizationPlugin;

class TranslationsPlugin implements Pluginable
{

    public function register(ContextService $context)
    {
        // Require dependencies
        $context->plugin(LocalizationPlugin::class);

        // Add exporter
        $context->extend('translations', function (...$arguments) {
            $this->exportTranslations(...$arguments);
        });
    }

    protected function exportTranslations(array $translations)
    {
        $data = [];

        foreach ($translations as $key) {
            $data[$key] = trans($key);
        }

        Context::localize('env.trans', $data);
    }

}