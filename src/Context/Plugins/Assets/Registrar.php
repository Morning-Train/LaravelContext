<?php

namespace MorningTrain\Laravel\Context\Plugins\Assets;

use Illuminate\Support\Arr;

abstract class Registrar
{

    protected $entries = [];

    protected function toAttributesString(array $array)
    {
        $attributes = [];

        foreach ($array as $attribute => $value) {
            $attributes[] = $value === true ? $attribute : "{$attribute}=\"{$value}\"";
        }

        return implode(' ', $attributes);
    }

    public function add($entries, string $method = 'file')
    {
        foreach ((array)$entries as $entry) {
            if (!is_array($entry)) {
                $entry = ['src' => $entry];
            }

            array_push($this->entries, array_merge(['method' => $method], $entry));
        }

        return $this;
    }

    public function before($entries, string $method = 'file')
    {
        foreach ((array)$entries as $entry) {
            if (!is_array($entry)) {
                $entry = ['src' => $entry];
            }

            array_unshift($this->entries, array_merge(['method' => $method], $entry));
        }

        return $this;
    }

    public function plain($sources)
    {
        return $this->add($sources, 'plain');
    }

    public function plainBefore($sources)
    {
        return $this->before($sources, 'plain');
    }

    public function __toString()
    {
        $html = '';

        foreach ($this->entries as $entry) {
            $method = $entry['method'];
            $renderMethod = "{$method}ToString";

            if (method_exists($this, $renderMethod)) {
                $html .= $this->$renderMethod(Arr::except($entry, 'method'));
            }
        }

        return $html;
    }


}