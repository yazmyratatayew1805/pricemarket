<?php

namespace App\Domain\Order\Partials;

use App\Domain\Order\Enums\OrderStatus;
use App\Domain\Order\Events\OrderCancelled;
use App\Domain\Order\Events\OrderCompleted;
use Spatie\EventSourcing\AggregateRoots\AggregatePartial;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class OrderStateMachine extends AggregatePartial
{
    private OrderStatus $status;

    public function __construct(AggregateRoot $aggregateRoot)
    {
        parent::__construct($aggregateRoot);

        $this->status = OrderStatus::pending();
    }

    public function onOrderCompleted(OrderCompleted $event): void
    {
        $this->status = OrderStatus::completed();
    }

    public function onOrderCancelled(OrderCancelled $event): void
    {
        $this->status = OrderStatus::cancelled();
    }

    public function isPending(): bool
    {
        return $this->status->equals(OrderStatus::pending());
    }
}
