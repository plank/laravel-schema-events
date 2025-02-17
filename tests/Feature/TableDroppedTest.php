<?php

use Illuminate\Support\Facades\Event;
use Plank\LaravelSchemaEvents\Events\TableDropped;

use function Pest\Laravel\artisan;

it('emits table dropped events when the migrations drop tables', function () {
    Event::fake([TableDropped::class]);

    artisan('migrate', [
        '--path' => migrationPath('drop'),
        '--realpath' => true,
    ])->run();

    $events = Event::dispatched(TableDropped::class, fn () => true);

    expect($events)->toHaveCount(1);

    expect($event = $events[0][0])->toBeInstanceOf(TableDropped::class);

    // Connection Info
    expect($event->connection)->toBe('testing');
    expect($event->databaseName)->toBe(':memory:');
    expect($event->driverName)->toBe('sqlite');

    // Table
    expect($event->table)->toBe('posts');
});

it('emits table dropped events when the migrations "drop if exists" tables', function () {
    Event::fake([TableDropped::class]);

    artisan('migrate', [
        '--path' => migrationPath('drop_if_exists'),
        '--realpath' => true,
    ])->run();

    $events = Event::dispatched(TableDropped::class, fn () => true);

    expect($events)->toHaveCount(1);

    expect($event = $events[0][0])->toBeInstanceOf(TableDropped::class);

    // Connection Info
    expect($event->connection)->toBe('testing');
    expect($event->databaseName)->toBe(':memory:');
    expect($event->driverName)->toBe('sqlite');

    // Table
    expect($event->table)->toBe('posts');
});
