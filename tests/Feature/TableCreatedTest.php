<?php

use Illuminate\Support\Facades\Event;
use Plank\LaravelSchemaEvents\Events\TableCreated;

use function Pest\Laravel\artisan;

it('emits table created events when the migrations create tables', function () {
    Event::fake([TableCreated::class]);

    artisan('migrate', [
        '--path' => migrationPath('create'),
        '--realpath' => true,
    ])->run();

    $events = Event::dispatchedEvents();

    expect($events[TableCreated::class])->toHaveCount(1);
    expect($event = $events[TableCreated::class][0][0])->toBeInstanceOf(TableCreated::class);

    // Connection Info
    expect($event->connection)->toBe('testing');
    expect($event->databaseName)->toBe(':memory:');
    expect($event->driverName)->toBe('sqlite');

    // Table
    expect($event->table)->toBe('comments');

    // Columns
    expect($event->columns)->toContain('id');
    expect($event->columns)->toContain('user_id');
    expect($event->columns)->toContain('post_id');
    expect($event->columns)->toContain('body');
    expect($event->columns)->toContain('type');
    expect($event->columns)->toContain('created_at');
    expect($event->columns)->toContain('updated_at');
    
    // Indexes
    expect($event->indexes)->toContain('type');
    
    // FKs
    expect($event->foreignKeys)->toContain('comments_post_id_foreign');
    expect($event->foreignKeys)->toContain('comments_user_id_foreign');
});
