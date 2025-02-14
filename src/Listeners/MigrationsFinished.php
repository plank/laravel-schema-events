<?php

namespace Plank\LaravelSchemaEvents\Listeners;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Event;
use Plank\LaravelSchemaEvents\Facades\SchemaEvents;

class MigrationsFinished
{
    public function handle(MigrationsEnded $event)
    {
        SchemaEvents::get()
            ->each(fn ($event) => Event::dispatch($event));
    }
}
