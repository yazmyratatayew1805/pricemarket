<?php

namespace App\Domain\Cart\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CouponUsed extends ShouldBeStored
{
    public function __construct(
        public string $cartUuid,
        public string $couponCode,
        public int $couponReduction,
    ) {
    }
}
