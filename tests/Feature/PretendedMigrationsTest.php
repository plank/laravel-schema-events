<?php

use Illuminate\Support\Facades\Event;
use Plank\LaravelSchemaEvents\Events\TableDropped;

use function Pest\Laravel\artisan;

it('does not emit events during pretend migrations', function () {
    Event::fake([TableDropped::class]);

    artisan('migrate', [
        '--pretend' => true,
        '--path' => migrationPath('drop'),
        '--realpath' => true,
    ])->run();

    expect(Event::dispatched(TableDropped::class, fn () => true))->toBeEmpty();
});
