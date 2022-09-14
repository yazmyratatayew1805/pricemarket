<?php

namespace App\Domain\Cart\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CartItemRemoved extends ShouldBeStored
{
    public function __construct(
        public string $cartUuid,
        public string $cartItemUuid,
        public string $productId,
        public int $amount,
        public int $cartItemPriceExcludingVat,
        public int $cartItemPriceIncludingVat,
    ) {
    }
}
