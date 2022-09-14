<?php

namespace App\Domain\Cart\Events;

use App\Domain\Cart\DataTransferObjects\CartCheckoutData;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CartCheckedOut extends ShouldBeStored
{
    public function __construct(
        public string $cartUuid,
        public CartCheckoutData $cartCheckoutData
    ) {
    }
}
