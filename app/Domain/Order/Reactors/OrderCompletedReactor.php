<?php

namespace App\Domain\Order\Reactors;

use App\Domain\Order\Events\OrderCompleted;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class OrderCompletedReactor extends Reactor
{
    public function onOrderCompleted(OrderCompleted $orderCompleted): void
    {
        // Send Mail
    }
}
