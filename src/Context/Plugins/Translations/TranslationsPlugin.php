<?php

namespace MorningTrain\LaravelContext\Plugins\Translations;

use MorningTrain\LaravelContext\Context;
use MorningTrain\LaravelContext\ContextService;
use MorningTrain\LaravelContext\Contracts\Pluginable;
use MorningTrain\LaravelContext\Plugins\Localization\LocalizationPlugin;

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