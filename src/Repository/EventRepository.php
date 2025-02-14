<?php

namespace Plank\LaravelSchemaEvents\Repository;

use Illuminate\Support\Collection;

class EventRepository
{
    protected ?Collection $events = null;

    public function __construct()
    {
        $this->events = new Collection();
    }

    public function get()
    {
        $events = $this->events;

        $this->events = new Collection();

        return $events;
    }

    public function store(Collection $events)
    {
        $this->events = $this->events->concat($events);
    }
}
