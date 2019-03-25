<?php
namespace NimDevelopment\DBase\Facades;
use Illuminate\Support\Facades\Facade;

class DBase extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'DBase'; }
}


?>