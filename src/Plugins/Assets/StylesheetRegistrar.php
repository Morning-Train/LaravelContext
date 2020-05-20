<?php

namespace MorningTrain\Laravel\Context\Plugins\Assets;

use Illuminate\Support\Arr;

class StylesheetRegistrar extends Registrar
{

    protected function fileToString(array $entry)
    {
        $src = $entry['src'] ?? '';
        $entry = array_merge(['rel' => 'stylesheet', 'href' => $src], Arr::except($entry, 'src'));
        $attributes = $this->toAttributesString($entry);
        return "<link {$attributes} />";
    }

    protected function plainToString(array $entry)
    {
        $src = $entry['src'];
        $entry = Arr::except($entry, 'src');
        $attributes = $this->toAttributesString($entry);
        return "<style {$attributes}>{$src}</style>";
    }

}