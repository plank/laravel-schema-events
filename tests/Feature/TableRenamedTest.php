<?php

use Illuminate\Support\Facades\Event;
use Plank\LaravelSchemaEvents\Events\TableRenamed;

use function Pest\Laravel\artisan;

it('emits table dropped events when the migrations drop tables', function () {
    Event::fake([TableRenamed::class]);

    artisan('migrate', [
        '--path' => migrationPath('rename'),
        '--realpath' => true,
    ])->run();

    $events = Event::dispatchedEvents();

    expect($events[TableRenamed::class])->toHaveCount(1);
    expect($event = $events[TableRenamed::class][0][0])->toBeInstanceOf(TableRenamed::class);

    // Connection Info
    expect($event->connection)->toBe('testing');
    expect($event->databaseName)->toBe(':memory:');
    expect($event->driverName)->toBe('sqlite');

    // Table
    expect($event->from)->toBe('posts');
    expect($event->to)->toBe('articles');
});
