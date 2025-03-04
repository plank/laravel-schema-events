<?php

namespace Plank\LaravelSchemaEvents\Repository;

use Illuminate\Support\Collection;
use Plank\LaravelSchemaEvents\Events\TableChanged;
use Plank\LaravelSchemaEvents\Events\TableCreated;
use Plank\LaravelSchemaEvents\Events\TableDropped;
use Plank\LaravelSchemaEvents\Events\TableRenamed;

class EventRepository
{
    protected ?Collection $events = null;

    public function __construct()
    {
        $this->events = new Collection;
    }

    /**
     * @return Collection<TableCreated|TableChanged|TableDropped|TableRenamed>
     */
    public function get(): Collection
    {
        return $this->events;
    }

    /**
     * @return Collection<TableCreated>
     */
    public function created(): Collection
    {
        return $this->events->filter(fn ($event) => $event instanceof TableCreated)->values();
    }

    /**
     * @return Collection<TableChanged>
     */
    public function changed(): Collection
    {
        return $this->events->filter(fn ($event) => $event instanceof TableChanged)->values();
    }

    /**
     * @return Collection<TableDropped>
     */
    public function dropped(): Collection
    {
        return $this->events->filter(fn ($event) => $event instanceof TableDropped)->values();
    }

    /**
     * @return Collection<TableRenamed>
     */
    public function renamed(): Collection
    {
        return $this->events->filter(fn ($event) => $event instanceof TableRenamed)->values();
    }

    /**
     * @param Collection<TableCreated|TableChanged|TableDropped|TableRenamed> $events
     */
    public function store(Collection $events): void
    {
        $this->events = $this->events->concat($events);
    }

    public function flush(): void
    {
        $this->events = new Collection;
    }
}
