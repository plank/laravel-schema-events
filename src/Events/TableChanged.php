<?php

namespace Plank\LaravelSchemaEvents\Events;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Plank\LaravelSchemaEvents\Concerns\ParsesBlueprint;

/**
 * @property Collection<string> $addedColumns
 * @property Collection<string> $droppedColumns
 * @property Collection<array> $renamedColumns
 * @property Collection<string> $modifedColumns
 * @property Collection<string> $addedIndexes
 * @property Collection<string> $droppedIndexes
 * @property Collection<array> $renamedIndexes
 * @property Collection<string> $addedForeignKeys
 * @property Collection<string> $droppedForeignKeys
 */
final readonly class TableChanged
{
    use ParsesBlueprint;

    public function __construct(
        public string $connection,
        public string $databaseName,
        public string $driverName,
        public string $table,
        public Collection $addedColumns,
        public Collection $droppedColumns,
        public Collection $renamedColumns,
        public Collection $modifiedColumns,
        public Collection $addedIndexes,
        public Collection $droppedIndexes,
        public Collection $renamedIndexes,
        public Collection $addedForeignKeys,
        public Collection $droppedForeignKeys,
    ) {}

    public static function from(Connection $connection, Blueprint $blueprint): self
    {
        return new self(
            connection: $connection->getName(),
            databaseName: $connection->getDatabaseName(),
            driverName: $connection->getDriverName(),
            table: $blueprint->getTable(),
            addedColumns: self::parseAddedColumns($blueprint),
            droppedColumns: self::parseDroppedColumns($blueprint),
            renamedColumns: self::parseRenamedColumns($blueprint),
            modifiedColumns: self::parseModifiedColumns($blueprint),
            addedIndexes: self::parseAddedIndexes($blueprint),
            droppedIndexes: self::parseDroppedIndexes($blueprint),
            renamedIndexes: self::parseRenamedIndexes($blueprint),
            addedForeignKeys: self::parseAddedForeignKeys($blueprint),
            droppedForeignKeys: self::parseDroppedForeignKeys($blueprint),
        );
    }
}
