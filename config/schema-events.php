<?php

use Plank\LaravelSchemaEvents\Events\TableChanged;
use Plank\LaravelSchemaEvents\Events\TableCreated;
use Plank\LaravelSchemaEvents\Events\TableDropped;
use Plank\LaravelSchemaEvents\Events\TableRenamed;
use Plank\LaravelSchemaEvents\Listeners\MigrationRan;
use Plank\LaravelSchemaEvents\Listeners\MigrationsFinished;

return [
    /*
    |--------------------------------------------------------------------------
    | Listeners
    |--------------------------------------------------------------------------
    |
    | `ran`:
    | This listens to `MigrationStarted` events and bubbles up some more granular
    | events based on the changes taking place to the schema.
    |
    | If the `finished` listener is not configured, these events will bubble up
    | immediately.
    |
    | `finished`:
    | This listens for the completion of migrations being run and batches the more
    | granular events parsed during `ran` into one larger event to be processed.
    */
    'listeners' => [
        'ran' => MigrationRan::class,
        'finished' => MigrationsFinished::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Listeners
    |--------------------------------------------------------------------------
    |
    | `created`:
    | The event emitted when tables are created during migrations.
    |
    | `changed`:
    | The event emitted when tables are altered during migrations.
    |
    | `renamed`:
    | The event emitted when tables are renamed during migrations.
    |
    | `dropped`:
    | The event emitted when tables are dropped during migrations.
    |
    */
    'events' => [
        'created' => TableCreated::class,
        'changed' => TableChanged::class,
        'renamed' => TableRenamed::class,
        'dropped' => TableDropped::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Commands
    |--------------------------------------------------------------------------
    |
    | These are the blueprint commands we use to parse out the changes that occurred
    */
    'commands' => [
        'renamed_columns' => ['renameColumn'],
        'dropped_columns' => ['dropColumn'],
        'added_indexes' => [
            'primary',
            'unique',
            'index',
            'fulltext',
            'spatialIndex',
        ],
        'dropped_indexes' => [
            'dropPrimary',
            'dropUnique',
            'dropIndex',
            'dropFullText',
            'dropSpatialIndex',
        ],
        'renamed_indexes' => ['renameIndex'],
        'added_foreign_keys' => ['foreign'],
        'dropped_foreign_keys' => ['dropForeign'],
    ],
];
