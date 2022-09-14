<?php

namespace App\Domain\Cart\Reactors;

use App\Domain\Cart\Actions\FailCart;
use App\Domain\Order\Events\OrderCancelled;
use App\Domain\Order\Projections\Order;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class OrderForCartFailedReactor extends Reactor
{
    public function onOrderCancelled(OrderCancelled $event): void
    {
        /** @var \App\Domain\Order\Projections\Order $order */
        $order = Order::find($event->orderUuid);

        (new FailCart)($order->cart);
    }
}
