<?php

namespace Plank\LaravelSchemaEvents\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Plank\LaravelSchemaEvents\Repository\EventRepository;
use Plank\LaravelSchemaEvents\Events\TableChanged;
use Plank\LaravelSchemaEvents\Events\TableCreated;
use Plank\LaravelSchemaEvents\Events\TableDropped;
use Plank\LaravelSchemaEvents\Events\TableRenamed;

/**
 * @method static void store(Collection<TableCreated|TableChanged|TableDropped|TableRenamed> $events)
 * @method static Collection<TableCreated|TableChanged|TableDropped|TableRenamed> get()
 */
class SchemaEvents extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EventRepository::class;
    }
}
