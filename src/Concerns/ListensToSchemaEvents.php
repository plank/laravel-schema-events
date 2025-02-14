<?php

namespace Plank\LaravelSchemaEvents\Concerns;

use Closure;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Collection;
use Plank\LaravelSchemaEvents\Events\TableChanged;
use Plank\LaravelSchemaEvents\Events\TableCreated;
use Plank\LaravelSchemaEvents\Events\TableDropped;
use Plank\LaravelSchemaEvents\Events\TableRenamed;

/**
 * @mixin Builder
 */
trait ListensToSchemaEvents
{
    protected ?Collection $events = null;

    public function __construct(Connection $connection)
    {
        $this->events = new Collection();

        parent::__construct($connection);
    }

    /**
     * @return Collection<TableCreated|TableChanged|TableDropped|TableRenamed>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function create($table, Closure $callback)
    {
        $blueprint = $this->createBlueprint($table, $callback);

        $this->events->push(TableCreated::from($this->connection, $blueprint));
    }

    public function drop($table)
    {
        $this->events->push(TableDropped::from($this->connection, $table));
    }

    public function dropIfExists($table)
    {
        if ($this->hasTable($table)) {
            $this->events->push(TableDropped::from($this->connection, $table));
        }
    }

    public function table($table, Closure $callback)
    {
        $blueprint = $this->createBlueprint($table, $callback);

        $this->events->push(TableChanged::from($this->connection, $blueprint));
    }

    public function rename($from, $to)
    {
        $this->events->push(TableRenamed::from($this->connection, $from, $to));
    }

    public function hasTable($table)
    {
        return $this->connection->withoutPretending(fn () => parent::hasTable($table));
    }

    public function getTables($withSize = true)
    {
        return $this->connection->withoutPretending(fn () => parent::getTables());
    }

    /**
     * Get the views that belong to the database.
     *
     * @return array
     */
    public function getViews()
    {
        return $this->connection->withoutPretending(fn () => parent::getViews());
    }

    /**
     * Get the columns for a given table.
     *
     * @param  string  $table
     * @return array
     */
    public function getColumns($table)
    {
        return $this->connection->withoutPretending(fn () => parent::getColumns($table));
    }

    /**
     * Get the indexes for a given table.
     *
     * @param  string  $table
     * @return array
     */
    public function getIndexes($table)
    {
        return $this->connection->withoutPretending(fn () => parent::getIndexes($table));
    }

    /**
     * Get the foreign keys for a given table.
     *
     * @param  string  $table
     * @return array
     */
    public function getForeignKeys($table)
    {
        return $this->connection->withoutPretending(fn () => parent::getForeignKeys($table));
    }

    /**
     * Get the user-defined types that belong to the database.
     *
     * @return array
     */
    public function getTypes()
    {
        return $this->connection->withoutPretending(fn () => parent::getTypes());
    }
}
