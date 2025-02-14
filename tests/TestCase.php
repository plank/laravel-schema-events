<?php

namespace Plank\LaravelSchemaEvents\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Kfriars\ConnectionShim\ConnectionShimServiceProvider;
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
            ConnectionShimServiceProvider::class,
            LaravelSchemaEventsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
