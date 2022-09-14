<?php

namespace App\Domain\Cart\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CartPaid extends ShouldBeStored
{
    public function __construct(
        public string $cartUuid,
    ) {
    }
}
