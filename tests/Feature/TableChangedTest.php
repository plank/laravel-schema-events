<?php

use Illuminate\Support\Facades\Event;
use Plank\LaravelSchemaEvents\Events\TableChanged;

use function Pest\Laravel\artisan;

it('emits table changed events when the migrations change tables', function () {
    Event::fake([TableChanged::class]);

    artisan('migrate', [
        '--path' => migrationPath('change'),
        '--realpath' => true,
    ])->run();

    $events = Event::dispatched(TableChanged::class, fn () => true);
    
    expect($events)->toHaveCount(5);

    // Connection Info
    $event = $events[0][0];

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
    
    expect($event->addedIndexes)->toContain('posts_slug_unique');
    expect($event->addedIndexes)->toContain('posts_published_at_index');

    expect($event->addedForeignKeys)->toContain('posts_publisher_id_foreign');

    $event = $events[1][0];
    expect($event->renamedColumns)->toContain([
        'from' => 'description',
        'to' => 'blurb',
    ]);

    // Indexes
    $event = $events[2][0];
    expect($event->droppedColumns)->toContain('teaser');
    
    $event = $events[3][0];
    expect($event->droppedIndexes)->toContain('posts_tag_index');
    
    $event = $events[4][0];
    expect($event->renamedIndexes)->toContain([
        'from' => 'posts_category_index',
        'to' => 'category_index',
    ]);
});
