<?php

namespace MorningTrain\Laravel\Context\Plugins\Assets;

class ScriptRegistrar extends Registrar
{

    protected function fileToString(array $entry)
    {
        $attributes = $this->toAttributesString($entry);
        return "<script {$attributes}></script>";
    }

    protected function plainToString(array $entry)
    {
        $src = $entry['src'] ?? '';
        $attributes = $this->toAttributesString(array_except($entry, 'src'));
        return "<script {$attributes}>{$src}</script>";
    }

}