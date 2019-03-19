<?php

namespace MorningTrain\Laravel\Context\Plugins\Assets;

class ScriptRegistrar extends Registrar
{

    protected function fileToString($src)
    {
        return sprintf('<script src="%s"></script>', $src);
    }

    protected function plainToString($src)
    {
        return "<script>{$src}</script>";
    }

}