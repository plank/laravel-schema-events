<?php

namespace Plank\LaravelSchemaEvents\Concerns;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Fluent;

trait ParsesBlueprint
{
    protected static function parseAddedColumns(Blueprint $blueprint): Collection
    {
        return (new Collection($blueprint->getColumns()))
            ->reject(fn (ColumnDefinition $column) => $column->change)
            ->pluck('name')
            ->values();
    }

    protected static function parseModifiedColumns(Blueprint $blueprint): Collection
    {
        return (new Collection($blueprint->getColumns()))
            ->filter(fn (ColumnDefinition $column) => $column->change)
            ->pluck('name')
            ->values();
    }

    protected static function parseRenamedColumns(Blueprint $blueprint): Collection
    {
        return (new Collection($blueprint->getCommands()))
            ->whereIn('name', config()->get('schema-events.commands.renamed_columns'))
            ->map(fn (Fluent $command) => ['from' => $command->from, 'to' => $command->to])
            ->values();
    }

    protected static function parseDroppedColumns(Blueprint $blueprint): Collection
    {
        return (new Collection($blueprint->getCommands()))
            ->whereIn('name', config()->get('schema-events.commands.dropped_columns'))
            ->map(fn (Fluent $command) => Arr::wrap($command->columns))
            ->flatten()
            ->values();
    }

    protected static function parseAddedIndexes(Blueprint $blueprint): Collection
    {
        $fromCommands = (new Collection($blueprint->getCommands()))
            ->whereIn('name', config()->get('schema-events.commands.added_indexes'))
            ->pluck('index');

        $fromColumns = (new Collection($blueprint->getColumns()))
            ->filter(fn (ColumnDefinition $column) => $column->index)
            ->pluck('name');

        return $fromCommands->concat($fromColumns)->values();
    }

    protected static function parseDroppedIndexes(Blueprint $blueprint): Collection
    {
        return (new Collection($blueprint->getCommands()))
            ->whereIn('name', config()->get('schema-events.commands.dropped_indexes'))
            ->pluck('index')
            ->values();
    }

    protected static function parseRenamedIndexes(Blueprint $blueprint): Collection
    {
        return (new Collection($blueprint->getCommands()))
            ->whereIn('name', config()->get('schema-events.commands.renamed_indexes'))
            ->map(fn (Fluent $command) => ['from' => $command->from, 'to' => $command->to])
            ->values();
    }

    protected static function parseAddedForeignKeys(Blueprint $blueprint): Collection
    {
        return (new Collection($blueprint->getCommands()))
            ->whereIn('name', config()->get('schema-events.commands.added_foreign_keys'))
            ->pluck('index')
            ->values();
    }

    protected static function parseDroppedForeignKeys(Blueprint $blueprint): Collection
    {
        return (new Collection($blueprint->getCommands()))
            ->whereIn('name', config()->get('schema-events.commands.dropped_foreign_keys'))
            ->pluck('index')
            ->values();
    }
}
