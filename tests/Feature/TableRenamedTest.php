<?php

use Illuminate\Support\Facades\Event;
use Plank\LaravelSchemaEvents\Events\TableRenamed;

use function Pest\Laravel\artisan;

it('emits table renamed events when the migrations rename tables', function () {
    Event::fake([TableRenamed::class]);

    artisan('migrate', [
        '--path' => migrationPath('rename'),
        '--realpath' => true,
    ])->run();

    $events = Event::dispatched(TableRenamed::class, fn () => true);

    expect($events)->toHaveCount(1);

    expect($event = $events[0][0])->toBeInstanceOf(TableRenamed::class);

    // Connection Info
    expect($event->connection)->toBe('testing');
    expect($event->databaseName)->toBe(':memory:');
    expect($event->driverName)->toBe('sqlite');

    // Table
    expect($event->from)->toBe('posts');
    expect($event->to)->toBe('articles');
});
