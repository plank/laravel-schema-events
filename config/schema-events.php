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
    | This listens to `MigrationStarted` event which is dispatched before each
    | migration file is run. This listener is responsible for collecting the
    | schema events that will be occurring during the run.
    |
    | `finished`:
    | This listens for the completion of migrations being run and emits all
    | of the collected schema events. If this is
    |
    */
    'listeners' => [
        'ran' => MigrationRan::class,
        'finished' => MigrationsFinished::class,
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
