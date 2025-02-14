<?php

namespace Plank\LaravelSchemaEvents\Events;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Plank\LaravelSchemaEvents\Concerns\ParsesBlueprint;
use Plank\LaravelSchemaEvents\Contracts\SchemaEvent;

/**
 * @property Collection<string> $columns
 * @property Collection<string> $indexes
 * @property Collection<string> $foreignKeys
 */
final readonly class TableCreated
{
    use ParsesBlueprint;

    public function __construct(
        public string $connection,
        public string $databaseName,
        public string $driverName,
        public string $table,
        public Collection $columns,
        public Collection $indexes,
        public Collection $foreignKeys,
    ) {}

    public static function from(Connection $connection, Blueprint $blueprint): self
    {
        return new self(
            connection: $connection->getName(),
            databaseName: $connection->getDatabaseName(),
            driverName: $connection->getDriverName(),
            table: $blueprint->getTable(),
            columns: static::parseAddedColumns($blueprint),
            indexes: static::parseAddedIndexes($blueprint),
            foreignKeys: static::parseAddedForeignKeys($blueprint),
        );
    }
}
