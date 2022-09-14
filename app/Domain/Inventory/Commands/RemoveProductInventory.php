<?php

namespace App\Domain\Inventory\Commands;

use App\Domain\Inventory\InventoryAggregateRoot;
use App\Domain\Product\Product;
use Spatie\EventSourcing\Commands\AggregateUuid;
use Spatie\EventSourcing\Commands\HandledBy;

#[HandledBy(InventoryAggregateRoot::class)]
class RemoveProductInventory
{
    public function __construct(
        #[AggregateUuid] public string $inventoryUuid,
        public Product $product,
        public int $amount,
    ) {
    }
}
