<?php

namespace Plank\LaravelSchemaEvents\Listeners;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Events\MigrationStarted;
use Illuminate\Support\Collection;
use Plank\LaravelSchemaEvents\Facades\SchemaEvents;
use Plank\LaravelSchemaEvents\Factory\EventSchemaFactory;

class MigrationRan
{
    public function __construct(
        protected Container $container,
        protected DatabaseManager $resolver,
    ) {}

    public function handle(MigrationStarted $event)
    {
        $connection = $this->resolver->connection($event->migration->getConnection());

        $events = $this->parseMigrationEvents($connection, function () use ($event) {
            $event->migration->{$event->method}();
        });

        SchemaEvents::store($events);
    }

    protected function parseMigrationEvents(Connection $connection, Closure $callback): Collection
    {
        $activeInServiceContainer = $this->container->make('db.schema');
        $activeOnConnection = $connection->getSchemaBuilder();
        $hasConfigurableSchema = is_a($connection, 'Kfriars\ConnectionShim\Contracts\ConfigurableSchema', true);

        try {
            $schema = EventSchemaFactory::forConnection($connection);
            $this->container->instance('db.schema', $schema);

            if ($hasConfigurableSchema) {
                $connection->setSchemaBuilder($schema);
            }

            $connection->pretend(fn () => $callback());
        } finally {
            $this->container->instance('db.schema', $activeInServiceContainer);

            if ($hasConfigurableSchema) {
                $connection->setSchemaBuilder($activeOnConnection);
            }
        }

        return $schema->getEvents();
    }
}
