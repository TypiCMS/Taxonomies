<?php

namespace TypiCMS\Modules\Taxonomies\Facades;

use Illuminate\Support\Facades\Facade;

class Taxonomies extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Taxonomies';
    }
}
