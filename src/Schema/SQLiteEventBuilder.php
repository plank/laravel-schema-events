<?php

namespace Plank\LaravelSchemaEvents\Schema;

use Illuminate\Database\Schema\SQLiteBuilder;
use Plank\LaravelSchemaEvents\Concerns\ListensToSchemaEvents;
use Plank\LaravelSchemaEvents\Contracts\CollectsSchemaEvents;

class SQLiteEventBuilder extends SQLiteBuilder implements CollectsSchemaEvents
{
    use ListensToSchemaEvents;
}
