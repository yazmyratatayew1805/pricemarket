<?php

namespace App\Domain\Order\Queries;

use App\Domain\Order\Events\OrderCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\EventQuery;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class NextOrderNumber extends EventQuery
{
    private ?string $number = null;

    private const PREFIX = "ORDER-";

    public function __construct()
    {
        /** @var \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder $query */
        $query = EloquentStoredEvent::query();

        /** @var \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent|null $event */
        $event = $query
            ->whereEvent(OrderCreated::class)
            ->orderByDesc('created_at')
            ->first();

        if ($event) {
            $this->apply($event->toStoredEvent());
        }
    }

    protected function onOrderCreated(OrderCreated $event): void
    {
        preg_match('/[\d]+/', $event->orderNumber, $previousNumber);

        $previousNumber = (int) $previousNumber[0];

        $nextNumber = $previousNumber + 1;

        $this->number = self::PREFIX . str_pad("$nextNumber", 5, "0", STR_PAD_LEFT);
    }

    public function getNumber(): string
    {
        return $this->number ?? 'ORDER-00001';
    }
}
