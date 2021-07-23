<?php

namespace Jota\OnuList\Facades;

use Illuminate\Support\Facades\Facade;

class OnuListFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'OnuList';
    }
}
