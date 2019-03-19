<?php

namespace MorningTrain\Laravel\Context\Plugins\Assets;

abstract class Registrar
{

    protected $entries = [];

    public function add($entries, string $type = 'file')
    {
        foreach ((array)$entries as $entry) {
            array_push($this->entries, [
                'type' => $type,
                'src' => $entry
            ]);
        }

        return $this;
    }

    public function before($entries, string $type = 'file')
    {
        foreach ((array)$entries as $entry) {
            array_unshift($this->entries, [
                'type' => $type,
                'src' => $entry
            ]);
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
            $type = $entry['type'];
            $src = $entry['src'];
            $method = "{$type}ToString";

            if (method_exists($this, $method)) {
                $html .= $this->$method($src);
            }
        }

        return $html;
    }

}