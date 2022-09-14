<?php

namespace App\Domain\Payment\Reactors;

use App\Domain\Order\Events\OrderCreated;
use App\Domain\Order\Projections\Order;
use App\Domain\Payment\Actions\CreatePayment;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class OrderToPaymentReactor extends Reactor
{
    public function onOrderCreated(OrderCreated $event): void
    {
        /** @var \App\Domain\Order\Projections\Order $order */
        $order = Order::find($event->orderUuid);

        (new CreatePayment)($order);
    }
}
