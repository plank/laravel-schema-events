<?php

namespace Plank\LaravelSchemaEvents\Schema;

use Illuminate\Database\Schema\MySqlBuilder;
use Plank\LaravelSchemaEvents\Concerns\ListensToSchemaEvents;
use Plank\LaravelSchemaEvents\Contracts\CollectsSchemaEvents;

class MySqlEventBuilder extends MySqlBuilder implements CollectsSchemaEvents
{
    use ListensToSchemaEvents;
}
