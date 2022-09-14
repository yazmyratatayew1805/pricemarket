<?php

namespace App\Domain\Order\Events;

use Carbon\Carbon;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderCancelled extends ShouldBeStored
{
    public function __construct(
        public string $orderUuid,
        public Carbon $canceledAt,
    ) {
    }
}
