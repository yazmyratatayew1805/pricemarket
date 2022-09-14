<?php

namespace App\Domain\Cart\Events;

use App\Domain\Product\Price;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ShippingCostsAdded extends ShouldBeStored
{
    public function __construct(
        public string $cartUuid,
        public Price $shippingCost,
    ) {
    }
}
