<?php

namespace Plank\LaravelSchemaEvents\Schema;

use Illuminate\Database\Schema\SqlServerBuilder;
use Plank\LaravelSchemaEvents\Concerns\ListensToSchemaEvents;
use Plank\LaravelSchemaEvents\Contracts\CollectsSchemaEvents;

class SqlServerEventBuilder extends SqlServerBuilder implements CollectsSchemaEvents
{
    use ListensToSchemaEvents;
}
