<?php

namespace Plank\LaravelSchemaEvents\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Plank\LaravelSchemaEvents\Events\TableChanged;
use Plank\LaravelSchemaEvents\Events\TableCreated;
use Plank\LaravelSchemaEvents\Events\TableDropped;
use Plank\LaravelSchemaEvents\Events\TableRenamed;
use Plank\LaravelSchemaEvents\Repository\EventRepository;

/**
 * @method static Collection<TableCreated|TableChanged|TableDropped|TableRenamed> get()
 * @method static Collection<TableCreated> created()
 * @method static Collection<TableChanged> changed()
 * @method static Collection<TableDropped> dropped()
 * @method static Collection<TableRenamed> renamed()
 * @method static void flush()
 * @method static void store(Collection<TableCreated|TableChanged|TableDropped|TableRenamed> $events)
 */
class SchemaEvents extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EventRepository::class;
    }
}
