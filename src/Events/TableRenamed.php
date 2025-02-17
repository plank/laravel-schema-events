<?php

namespace Plank\LaravelSchemaEvents\Events;

use Illuminate\Database\Connection;

final readonly class TableRenamed
{
    public function __construct(
        public ?string $connection,
        public ?string $databaseName,
        public ?string $driverName,
        public string $from,
        public string $to,
    ) {}

    public static function from(Connection $connection, string $from, string $to)
    {
        $self = new self(
            connection: $connection->getName(),
            databaseName: $connection->getDatabaseName(),
            driverName: $connection->getDriverName(),
            from: $from,
            to: $to,
        );

        dump($self);

        return $self;
    }
}
