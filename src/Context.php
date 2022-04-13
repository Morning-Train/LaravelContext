<?php

namespace MorningTrain\Laravel\Context;

use MorningTrain\Laravel\Context\Traits\HasAssetsContext;
use MorningTrain\Laravel\Context\Traits\HasBreadcrumbsContext;
use MorningTrain\Laravel\Context\Traits\HasEnvContext;
use MorningTrain\Laravel\Context\Traits\HasMenuContext;
use MorningTrain\Laravel\Context\Traits\HasMetaContext;
use MorningTrain\Laravel\Context\Traits\HasRoutesContext;
use MorningTrain\Laravel\Context\Traits\HasTranslationsContext;
use MorningTrain\Laravel\Context\Traits\HasViewsContext;

final class Context
{

    use HasAssetsContext;
    use HasBreadcrumbsContext;
    use HasEnvContext;
    use HasMenuContext;
    use HasMetaContext;
    use HasRoutesContext;
    use HasTranslationsContext;
    use HasViewsContext;

    //////////////////////////
    /// Registering contexts
    //////////////////////////

    public static array $features = [];

    public static function register(string $name, string $class): void
    {
        Context::$features[$name] = $class;
    }

    public static function featureExists($name): bool
    {
        return isset(Context::$features[$name]);
    }

    public static function getFeatureClass($name)
    {
        return Context::$features[$name];
    }

    //////////////////////////
    /// Loading contexts
    //////////////////////////

    public static array $loaded = [];
    public static array $loaded_features = [];

    public static function load(string $name): void
    {
        $class = null;

        if (!Context::featureExists($name)) {
            // Check if class
            if (class_exists($name)) {
                $class = $name;
            }
        } else {
            $class = Context::getFeatureClass($name);
        }

        if (is_null($class)) {
            throw new \Exception(sprintf('Context feature `%s` is not defined.', $name));
        }

        $feature = new $class();

        if (method_exists($feature, 'load')) {
            $feature->load();
        }

        Context::$loaded[] = $name;
        Context::$loaded_features[$class] = $feature;
    }

    public function is($name)
    {
        return in_array($name, Context::$loaded);
    }

    //////////////////////////
    /// Booting contexts
    //////////////////////////

    public static function boot($feature_class = null)
    {
        $loaded_features = Context::$loaded_features;

        if($feature_class !== null) {
            if (is_array($loaded_features) && isset($loaded_features[$feature_class])) {
                $feature = $loaded_features[$feature_class];
                if (method_exists($feature, 'boot')) {
                    $feature->boot();
                }
            }

            return;
        }

        if (is_array($loaded_features) && !empty($loaded_features)) {
            foreach ($loaded_features as $feature) {
                if (method_exists($feature, 'boot')) {
                    $feature->boot();
                }
            }
        }
    }

}
