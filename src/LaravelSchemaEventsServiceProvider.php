<?php

namespace Plank\LaravelSchemaEvents;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Database\Events\MigrationStarted;
use Illuminate\Support\Facades\Event;
use Plank\LaravelSchemaEvents\Repository\EventRepository;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasConfigFile();
    }

    public function bootingPackage()
    {
        $this->app->scopedIf(EventRepository::class, function () {
            return new EventRepository;
        });

        Event::listen(MigrationStarted::class, config()->get('schema-events.listeners.ran'));

        // If the MigrationsEnded listener is not configured, the consuming
        // application wants to handle dispacthing the events itself.
        if ($listener = config()->get('schema-events.listeners.finished')) {
            Event::listen(MigrationsEnded::class, $listener);
        }

        return $this;
    }
}
