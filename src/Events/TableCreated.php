<?php

namespace Plank\LaravelSchemaEvents\Events;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Plank\LaravelSchemaEvents\Concerns\ParsesBlueprint;

/**
 * @property Collection<string> $columns
 * @property Collection<string> $indexes
 * @property Collection<string> $foreignKeys
 */
final class TableCreated
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
            table: $connection->getTablePrefix().$blueprint->getTable(),
            columns: self::parseAddedColumns($blueprint),
            indexes: self::parseAddedIndexes($blueprint),
            foreignKeys: self::parseAddedForeignKeys($blueprint),
        );
    }
}
