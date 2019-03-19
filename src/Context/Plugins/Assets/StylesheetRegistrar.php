<?php

namespace MorningTrain\LaravelContext\Plugins\Assets;

class StylesheetRegistrar extends Registrar
{

    protected function fileToString($src)
    {
        return sprintf('<link rel="stylesheet" href="%s" />', $src);
    }

    protected function plainToString($src)
    {
        return "<style>{$src}</style>";
    }

}