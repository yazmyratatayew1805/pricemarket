<?php

namespace App\Domain\Order\Actions;

use App\Domain\Order\OrderAggregateRoot;
use App\Domain\Order\Projections\Order;

class FailOrder
{
    public function __invoke(Order $order): Order
    {
        OrderAggregateRoot::retrieve($order->uuid)
            ->cancel()
            ->persist();

        return $order->refresh();
    }
}
