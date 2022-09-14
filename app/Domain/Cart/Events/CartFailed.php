<?php

namespace App\Domain\Cart\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CartFailed extends ShouldBeStored
{
    public function __construct(
        public string $cartUuid,
    ) {
    }
}
