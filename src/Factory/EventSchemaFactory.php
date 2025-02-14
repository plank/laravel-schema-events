<?php

namespace Plank\LaravelSchemaEvents\Factory;

use Illuminate\Database\Connection;
use Illuminate\Database\MariaDbConnection;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\PostgresConnection;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\SqlServerConnection;
use Plank\LaravelSchemaEvents\Schema\EventBuilder;
use Plank\LaravelSchemaEvents\Schema\MariaDbEventBuilder;
use Plank\LaravelSchemaEvents\Schema\MySqlEventBuilder;
use Plank\LaravelSchemaEvents\Schema\PostgresEventBuilder;
use Plank\LaravelSchemaEvents\Schema\SQLiteEventBuilder;
use Plank\LaravelSchemaEvents\Schema\SqlServerEventBuilder;

class EventSchemaFactory
{
    public static function forConnection(Connection $connection)
    {
        if ($connection instanceof MySqlConnection) {
            return new MySqlEventBuilder($connection);
        }

        if ($connection instanceof SQLiteConnection) {
            return new SQLiteEventBuilder($connection);
        }

        if ($connection instanceof PostgresConnection) {
            return new PostgresEventBuilder($connection);
        }

        if ($connection instanceof MariaDbConnection) {
            return new MariaDbEventBuilder($connection);
        }
        
        if ($connection instanceof SqlServerConnection) {
            return new SqlServerEventBuilder($connection);
        }

        return new EventBuilder($connection);
    }
}