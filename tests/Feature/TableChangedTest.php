<?php

use Illuminate\Support\Facades\Event;
use Plank\LaravelSchemaEvents\Events\TableChanged;

use function Pest\Laravel\artisan;

it('emits table created events when the migrations create tables', function () {
    Event::fake([TableChanged::class]);

    artisan('migrate', [
        '--path' => migrationPath('change'),
        '--realpath' => true,
    ])->run();

    $events = Event::dispatchedEvents();

    expect($events[TableChanged::class])->toHaveCount(1);
    expect($event = $events[TableChanged::class][0][0])->toBeInstanceOf(TableChanged::class);

    // Connection Info
    expect($event->connection)->toBe('testing');
    expect($event->databaseName)->toBe(':memory:');
    expect($event->driverName)->toBe('sqlite');

    // Table
    expect($event->table)->toBe('posts');

    // Columns
    expect($event->addedColumns)->toContain('subtitle');
    expect($event->addedColumns)->toContain('slug');
    expect($event->addedColumns)->toContain('publisher_id');
    expect($event->addedColumns)->toContain('published_at');

    expect($event->modifiedColumns)->toContain('body');

    expect($event->droppedColumns)->toContain('teaser');

    expect($event->renamedColumns)->toContain([
        'from' => 'description',
        'to' => 'blurb',
    ]);
    
    // Indexes
    expect($event->addedIndexes)->toContain('posts_slug_unique');
    expect($event->addedIndexes)->toContain('posts_published_at_index');

    expect($event->droppedIndexes)->toContain('posts_tag_index');

    expect($event->renamedIndexes)->toContain([
        'from' => 'posts_category_index',
        'to' => 'category_index',
    ]);

    // FKs
    expect($event->addedForeignKeys)->toContain('posts_publisher_id_foreign');
    expect($event->droppedForeignKeys)->toContain('posts_author_id_foreign');
});
