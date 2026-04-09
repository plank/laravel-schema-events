<?php

use Illuminate\Support\Facades\DB;
use Plank\LaravelSchemaEvents\Factory\EventSchemaFactory;

use function Pest\Laravel\artisan;
use function Pest\Laravel\instance;

it('can get tables', function () {
    $connection = DB::connection();

    instance('db.schema', $schema = EventSchemaFactory::forConnection($connection));

    $connection->pretend(function () use ($schema) {
        $tables = collect($schema->getTables())->pluck('name');

        expect($tables)->toContain('migrations');
        expect($tables)->toContain('posts');
        expect($tables)->toContain('users');
    });
});

it('can get views', function () {
    artisan('migrate', [
        '--path' => migrationPath('view'),
        '--realpath' => true,
    ])->run();

    $connection = DB::connection();

    instance('db.schema', $schema = EventSchemaFactory::forConnection($connection));

    $connection->pretend(function () use ($schema) {
        $views = collect($schema->getViews())->pluck('name');

        expect($views)->toContain('post_authors');
    });
});

it('can get columns', function () {
    $connection = DB::connection();

    instance('db.schema', $schema = EventSchemaFactory::forConnection($connection));

    $connection->pretend(function () use ($schema) {
        $columns = collect($schema->getColumns('users'))->pluck('name');

        expect($columns)->toContain('id');
        expect($columns)->toContain('name');
        expect($columns)->toContain('created_at');
        expect($columns)->toContain('updated_at');
    });
});

it('can get indexes', function () {
    $connection = DB::connection();

    instance('db.schema', $schema = EventSchemaFactory::forConnection($connection));

    $connection->pretend(function () use ($schema) {
        $indexes = collect($schema->getIndexes('posts'))->pluck('name');

        expect($indexes)->toContain('posts_category_index');
        expect($indexes)->toContain('posts_tag_index');
        expect($indexes)->toContain('primary');
    });
});

it('can get foreign keys', function () {
    $connection = DB::connection();

    instance('db.schema', $schema = EventSchemaFactory::forConnection($connection));

    $connection->pretend(function () use ($schema) {
        $fks = collect($schema->getForeignKeys('posts'));

        expect($fks->filter(function ($fk) {
            return $fk['columns'][0] === 'author_id';
        }))->not->toBeEmpty();
    });
});

it('can get types', function () {
    $connection = DB::connection();

    instance('db.schema', $schema = EventSchemaFactory::forConnection($connection));

    $connection->pretend(function () use ($schema) {
        expect(fn () => $schema->getTypes())->toThrow(LogicException::class);
    });
});
