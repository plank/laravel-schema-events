<?php

namespace Plank\LaravelSchemaEvents\Commands;

use Illuminate\Console\Command;

class LaravelSchemaEventsCommand extends Command
{
    public $signature = 'laravel-schema-events';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
