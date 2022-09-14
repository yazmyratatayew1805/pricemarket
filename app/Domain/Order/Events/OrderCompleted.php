<?php

namespace App\Domain\Order\Events;

use Carbon\Carbon;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderCompleted extends ShouldBeStored
{
    public function __construct(
        public string $orderUuid,
        public Carbon $completedAt,
        public string $invoicePath,
    ) {
    }
}
