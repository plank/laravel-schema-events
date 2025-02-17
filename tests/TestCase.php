<?php

namespace Plank\LaravelSchemaEvents\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Plank\LaravelSchemaEvents\LaravelSchemaEventsServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--path' => realpath(__DIR__.'/Migrations/setup'),
            '--realpath' => true,
        ])->run();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelSchemaEventsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
