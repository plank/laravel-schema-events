<?php

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

    /**
     * Determine if we should be listening to pretended migrations
     */
    'listen_to_pretend' => false,

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
