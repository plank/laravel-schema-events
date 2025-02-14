<?php

namespace Plank\LaravelSchemaEvents\Schema;

use Illuminate\Database\Schema\Builder;
use Plank\LaravelSchemaEvents\Concerns\ListensToSchemaEvents;
use Plank\LaravelSchemaEvents\Contracts\CollectsSchemaEvents;

class EventBuilder extends Builder implements CollectsSchemaEvents
{
    use ListensToSchemaEvents;
}
