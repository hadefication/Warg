<?php

namespace Hadefication\Warg;

use Illuminate\Support\Facades\Facade;

class WargFacade extends Facade
{
    /**
     * Get facade accessor
     *
     * @return string
     * @author hadefication
     */
    protected static function getFacadeAccessor()
    {
        return 'warg';
    }
}
