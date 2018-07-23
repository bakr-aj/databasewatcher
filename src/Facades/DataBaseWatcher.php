<?php

namespace bakraj\DataBaseWatcher\Facades;

use Illuminate\Support\Facades\Facade;

class DataBaseWatcher extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'databasewatcher';
    }
}
