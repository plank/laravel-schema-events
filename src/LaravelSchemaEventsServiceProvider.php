<?php

namespace Plank\LaravelSchemaEvents;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Plank\LaravelSchemaEvents\Commands\LaravelSchemaEventsCommand;

class LaravelSchemaEventsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-schema-events')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_schema_events_table')
            ->hasCommand(LaravelSchemaEventsCommand::class);
    }
}
