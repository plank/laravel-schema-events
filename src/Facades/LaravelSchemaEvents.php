<?php

namespace Plank\LaravelSchemaEvents\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Plank\LaravelSchemaEvents\LaravelSchemaEvents
 */
class LaravelSchemaEvents extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Plank\LaravelSchemaEvents\LaravelSchemaEvents::class;
    }
}
