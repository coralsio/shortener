<?php

namespace Corals\Modules\Shortener\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Shortener
 * @package Corals\Modules\Shortener\Facades
 * @method static getShortDomainsList()
 * @method static generateCodeForLink($link)
 */
class Shortener extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return \Corals\Modules\Shortener\Classes\Shortener::class;
    }
}
