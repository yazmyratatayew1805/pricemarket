<?php

namespace App\Domain\Order;

use App\Domain\Cart\Projections\Cart;
use App\Domain\Order\DataTransferObjects\OrderData;
use App\Domain\Order\Events\OrderCancelled;
use App\Domain\Order\Events\OrderCompleted;
use App\Domain\Order\Events\OrderCreated;
use App\Domain\Order\Exceptions\OrderCannotCancel;
use App\Domain\Order\Exceptions\OrderCannotComplete;
use App\Domain\Order\Partials\OrderStateMachine;
use App\Domain\Order\Queries\NextOrderNumber;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class OrderAggregateRoot extends AggregateRoot
{
    protected OrderStateMachine $state;

    public function __construct()
    {
        $this->state = new OrderStateMachine($this);
    }

    public static function create(string $uuid, Cart $cart): self
    {
        $order = self::retrieve($uuid);

        $nextOrderNumber = (new NextOrderNumber)->getNumber();

        $order->recordThat(new OrderCreated(
            orderUuid: $uuid,
            orderNumber: $nextOrderNumber,
            orderData: OrderData::fromCart($cart),
            createdAt: now(),
        ));

        return $order;
    }

    public function complete(string $invoicePath): self
    {
        if (! $this->state->isPending()) {
            throw new OrderCannotComplete();
        }

        $this->recordThat(new OrderCompleted(
            orderUuid: $this->uuid(),
            completedAt: now(),
            invoicePath: $invoicePath,
        ));

        return $this;
    }

    public function cancel(): self
    {
        if (! $this->state->isPending()) {
            throw new OrderCannotCancel();
        }

        $this->recordThat(new OrderCancelled(
            orderUuid: $this->uuid(),
            canceledAt: now(),
        ));

        return $this;
    }
}
