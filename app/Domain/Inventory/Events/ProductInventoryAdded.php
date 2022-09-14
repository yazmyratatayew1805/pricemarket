<?php

namespace App\Domain\Inventory\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ProductInventoryAdded extends ShouldBeStored
{
    public function __construct(
        public string $inventoryUuid,
        public int $productId,
        public int $amount,
    ) {
    }
}
