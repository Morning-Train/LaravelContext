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

class Context
{

    use HasAssetsContext;
    use HasBreadcrumbsContext;
    use HasEnvContext;
    use HasMenuContext;
    use HasMetaContext;
    use HasRoutesContext;
    use HasTranslationsContext;
    use HasViewsContext;

}
