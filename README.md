# Context


## Installation
The Laravel Context package can be installed from packagist using the follow command

`composer require morningtrain/laravel-context`

### Facade setup
There is a facade helper for accessing the current context. 
Add it as an alias to **config/app.php** using the following snippet.

`'Context' => MorningTrain\Laravel\Context\Context::class,`

### Service provider
Contexts are configured in a service provider. Add a service provider in **app/Providers** that extends *MorningTrain\Laravel\Context\ContextServiceProvider*

This could be a typical starter ContextServiceProvider which also should be registered in the **config/app.php** config file in Laravel.

```php
<?php

namespace App\Providers;

use App\Context\BaseContext;
use App\Context\App\AppContext;
use MorningTrain\Laravel\Context\ContextServiceProvider as ServiceProvider;
use MorningTrain\Laravel\Context\Plugins\Assets\AssetsPlugin;
use MorningTrain\Laravel\Context\Plugins\Env\EnvPlugin;
use MorningTrain\Laravel\Context\Plugins\Menus\MenusPlugin;
use MorningTrain\Laravel\Context\Plugins\Meta\MetaPlugin;
use MorningTrain\Laravel\Context\Plugins\Routes\RoutesPlugin;

class ContextServiceProvider extends ServiceProvider
{

    /**
     * Plugins to load
     *
     * @var array
     */
    protected $plugins = [
        AssetsPlugin::class,
        EnvPlugin::class,
        MenusPlugin::class,
        RoutesPlugin::class,
        MetaPlugin::class
    ];

    /**
     * Features to define
     *
     * @var array
     */
    protected $contexts = [
        'base'  => BaseContext::class,
        'app'   => AppContext::class,
    ];

    /**
     * Features to load
     *
     * @var array
     */
    protected $load = [
        'base'
    ];

}
```

It contains 3 properties that should be configured. 

Plugins are extra functionality that can be added which extends the normal behaviour of the context system.

The plugins displayed above are the typically used plugins - they are all shipped with the context package. 
Is is possible to develop project-specific plugins and hook them up here.

The *contexts* property defines and array of all contexts available in the system. They will be referenced by the configured name.
There will be a definition of the context classsed later.

*load* defines the contexts that should be automatically loaded. Contexts need to be defined here or loaded manually in order to provide any functionality.

### Context class
This is an example of a basic AppContext class.


```php
<?php

namespace App\Context\App;

use MorningTrain\Laravel\Context\Context;

class AppContext
{

    public function load()
    {
        // Provide the app name to ENV
        Context::env(function () {
            return [
                'app' => [
                    'name' => config('app.name')
                ]
            ];
        });

        // Load assets
        Context::load(Assets::class);

    }

}

```

Anything in the array returned by the closure added to the *env* method will be merged into the *env* variable for that context.
It can be used to provide a set of variables to for instance JavaScript.


Note the last call to `Context::load(Asset::class)`.
The *Asset* class is a simple class containing a load method. 
It is not essentially needed but is a way to split the context loading into multiple smaller and more maintainable classes.

This is a basic example of an *Asset* class.

```php
<?php

namespace App\Context\App;

use MorningTrain\Laravel\Context\Context;

class Assets
{

    protected $manifest = '';

    public function load()
    {
        Context::stylesheets([
            asset(mix('css/app.css', $this->manifest))
        ]);

        Context::scripts([
            asset(mix('js/manifest.js', $this->manifest)),
            asset(mix('js/vendor.js', $this->manifest)),
            asset(mix('js/app.js', $this->manifest))
        ]);
    }

}
```

This is where stylesheets and JavaScripts are configured and made available to the HTML blade view. 
This allows for more dynamic loading of scripts and keeps the base HTML templates clean.

### Context provider
ContextProviders were added in version 2.5.0 and is an updated approach to structuring the context class.

New features include the ability to register plugins directly from any ContextProvider, meaning that plugins can be removed from the ContextServiceProvider.
This shift away from registering the plugins in the service provider will leave plugin dependency to the classes actually implementing them.

The *Asset* example above and similar classes are now called *partials* and can be automatically loaded from any ContextProvider.

It is recommended that these partials also extends the `ContextProvider` base class to have support for plugins.   

Note that it is encouraged to split the context class up into partials instead of having custom logic inside the context class itself. 

The `AppContext` example will the look like this (without the app name example).

```php
<?php

namespace App\Context\App;

use MorningTrain\Laravel\Context\ContextProvider;

class AppContext extends ContextProvider
{

    protected $partials = [
        Assets::class,
    ];

}

```

And the Assets class like this

```php
<?php

namespace App\Context\App;

use MorningTrain\Laravel\Context\Context;
use MorningTrain\Laravel\Context\ContextProvider;
use MorningTrain\Laravel\Context\Plugins\Assets\AssetsPlugin;

class Assets extends ContextProvider
{

    public static $plugins = [
        AssetsPlugin::class
    ];
    
    protected $manifest = '';

    public function load()
    {
        Context::stylesheets([
            asset(mix('css/app.css', $this->manifest))
        ]);

        Context::scripts([
            asset(mix('js/manifest.js', $this->manifest)),
            asset(mix('js/vendor.js', $this->manifest)),
            asset(mix('js/app.js', $this->manifest))
        ]);
    }

}

```

### Middleware
Remember to add the context middleware to *app\Http\Kernel.php*.

The following snippet should be added as a route middleware.

`'context' => \MorningTrain\Laravel\Context\Middleware\LoadFeatures::class,`

To work with ContextProviders, the updated version should be used instead:

`'context' => \MorningTrain\Laravel\Context\Middleware\LoadContexts::class,`

To keep backward compatibility, the old middleware is kept for now.

## Loading contexts
Beside from loading contexts in the service provider, one would use the context middleware to load a context.

Add this middleware to any route group to load the **app** context during the load of those routes.

`'context:app'`

This way, any route under the group will gain access to any information added to the app context.

## Including scripts and stylesheets
Add `{!! Context::stylesheets() !!}` to the document header in order to generate HTML tags for all enqueued stylesheets.

Add `{!! Context::scripts() !!}` to the HTML body footer in order to generate script tags for all enqueued JavaScript files.

## Providing ENV to JavaScript
Use the following script in your blade HTML template in order to automatically generate a JavaScript object class *env*.

It will be an object representing the entire environment built in the loaded context.

`{!! Context::env() !!}`

# Credits
This package is developed and actively maintained by [Morningtrain](https://morningtrain.dk).

<!-- language: lang-none -->
     _- _ -__ - -- _ _ - --- __ ----- _ --_  
    (         Morningtrain, Denmark         )
     `---__- --__ _ --- _ -- ___ - - _ --_ ´ 
         o                                   
        .  ____                              
      _||__|  |  ______   ______   ______ 
     (        | |      | |      | |      |
     /-()---() ~ ()--() ~ ()--() ~ ()--() 
    --------------------------------------

