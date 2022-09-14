<?php

namespace App\Domain\Order\Actions;

use App\Domain\Order\OrderAggregateRoot;
use App\Domain\Order\Projections\Order;

class CompleteOrder
{
    public function __invoke(Order $order, string $invoicePath): Order
    {
        OrderAggregateRoot::retrieve($order->uuid)
            ->complete($invoicePath)
            ->persist();

        return $order->refresh();
    }
}
