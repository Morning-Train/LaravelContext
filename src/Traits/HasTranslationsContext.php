<?php

namespace MorningTrain\Laravel\Context\Traits;

use MorningTrain\Laravel\Context\Context;

trait HasTranslationsContext
{

    public static function translations(...$arguments): array
    {
        static::exportTranslations(...$arguments);
    }

    public static function exportTranslations(array $translations): void
    {
        $data = [];

        foreach ($translations as $key) {
            $data[$key] = trans($key);
        }

        Context::env('trans', $data);
    }

}
