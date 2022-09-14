<?php

namespace App\Domain\Order\Actions;

use App\Domain\Cart\Projections\Cart;
use App\Domain\Order\OrderAggregateRoot;
use App\Domain\Order\Projections\Order;
use App\Support\Uuid;

class CreateOrder
{
    public function __invoke(Cart $cart): Order
    {
        $orderUuid = Uuid::new();

        OrderAggregateRoot::create($orderUuid, $cart)->persist();

        /** @var \App\Domain\Order\Projections\Order $order */
        $order = Order::findOrFail($orderUuid);

        return $order;
    }
}
