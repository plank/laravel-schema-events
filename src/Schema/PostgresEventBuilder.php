<?php

namespace Plank\LaravelSchemaEvents\Schema;

use Illuminate\Database\Schema\PostgresBuilder;
use Plank\LaravelSchemaEvents\Concerns\ListensToSchemaEvents;
use Plank\LaravelSchemaEvents\Contracts\CollectsSchemaEvents;

class PostgresEventBuilder extends PostgresBuilder implements CollectsSchemaEvents
{
    use ListensToSchemaEvents;
}
