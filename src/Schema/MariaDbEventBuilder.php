<?php

namespace Plank\LaravelSchemaEvents\Schema;

use Illuminate\Database\Schema\MariaDbBuilder;
use Plank\LaravelSchemaEvents\Concerns\ListensToSchemaEvents;
use Plank\LaravelSchemaEvents\Contracts\CollectsSchemaEvents;

class MariaDbEventBuilder extends MariaDbBuilder implements CollectsSchemaEvents
{
    use ListensToSchemaEvents;
}
