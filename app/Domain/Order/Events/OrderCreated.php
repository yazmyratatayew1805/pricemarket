<?php

namespace App\Domain\Order\Events;

use App\Domain\Order\DataTransferObjects\OrderData;
use Carbon\Carbon;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OrderCreated extends ShouldBeStored
{
    public function __construct(
        public string $orderUuid,
        public string $orderNumber,
        public OrderData $orderData,
        public Carbon $createdAt,
    ) {
    }
}
