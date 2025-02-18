<?php

namespace Plank\LaravelSchemaEvents\Events;

use Illuminate\Database\Connection;

final readonly class TableDropped
{
    public function __construct(
        public string $connection,
        public string $databaseName,
        public string $driverName,
        public string $table,
    ) {}

    public static function from(Connection $connection, string $table)
    {
        return new self(
            connection: $connection->getName(),
            databaseName: $connection->getDatabaseName(),
            driverName: $connection->getDriverName(),
            table: $connection->getTablePrefix().$table,
        );
    }
}
