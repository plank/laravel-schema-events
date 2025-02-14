<?php

namespace Plank\LaravelSchemaEvents\Contracts;

use Illuminate\Support\Collection;
use Plank\LaravelSchemaEvents\Events\TableChanged;
use Plank\LaravelSchemaEvents\Events\TableCreated;
use Plank\LaravelSchemaEvents\Events\TableDropped;
use Plank\LaravelSchemaEvents\Events\TableRenamed;

interface CollectsSchemaEvents
{
    /**
     * @return Collection<TableCreated|TableChanged|TableDropped|TableRenamed>
     */
    public function getEvents(): Collection;
}
