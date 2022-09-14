<?php

namespace App\Domain\Cart\Events;

use App\Domain\Product\Price;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CartItemAdded extends ShouldBeStored
{
    public function __construct(
        public string $cartUuid,
        public string $cartItemUuid,
        public int $productId,
        public int $amount,
        public Price $currentPrice,
    ) {
    }

    public function totalPrice(): int
    {
        return $this->amount * $this->currentPrice->pricePerItemIncludingVat();
    }
}
