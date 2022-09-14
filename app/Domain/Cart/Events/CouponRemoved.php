<?php

namespace App\Domain\Cart\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CouponRemoved extends ShouldBeStored
{
    public function __construct(
        public string $cartUuid,
    ) {
    }
}
