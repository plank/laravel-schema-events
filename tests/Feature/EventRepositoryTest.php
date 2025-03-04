<?php

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Event;
use Plank\LaravelSchemaEvents\Facades\SchemaEvents;

use function Pest\Laravel\artisan;

it('events are collected and queried correctly', function () {
    Event::forget(MigrationsEnded::class);

    artisan('migrate', [
        '--path' => migrationPath('repository'),
        '--realpath' => true,
    ])->run();

    expect(SchemaEvents::get())->toHaveCount(4);
    expect(SchemaEvents::created())->toHaveCount(1);
    expect(SchemaEvents::changed())->toHaveCount(1);
    expect(SchemaEvents::renamed())->toHaveCount(1);
    expect(SchemaEvents::dropped())->toHaveCount(1);

    SchemaEvents::flush();
    expect(SchemaEvents::get())->toBeEmpty();
});
