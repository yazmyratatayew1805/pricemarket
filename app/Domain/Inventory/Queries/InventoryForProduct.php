<?php

namespace App\Domain\Inventory\Queries;

use App\Domain\Inventory\Events\ProductInventoryAdded;
use App\Domain\Inventory\Events\ProductInventoryRemoved;
use App\Domain\Product\Product;
use Spatie\EventSourcing\EventHandlers\Projectors\EventQuery;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class InventoryForProduct extends EventQuery
{
    private int $available = 0;

    public function __construct(
        private Product $product
    ) {
        /** @var \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder $query */
        $query = EloquentStoredEvent::query();

        $query
            ->whereEvent(ProductInventoryAdded::class, ProductInventoryRemoved::class)
            ->each(fn (EloquentStoredEvent $eloquentStoredEvent) => $this->apply($eloquentStoredEvent->toStoredEvent()));
    }

    public function available(): int
    {
        return $this->available;
    }

    protected function onInventoryAdded(
        ProductInventoryAdded $productInventoryAdded
    ): void {
        $this->available += $productInventoryAdded->amount;
    }

    protected function onInventoryRemoved(
        ProductInventoryRemoved $productInventoryAdded
    ): void {
        $this->available -= $productInventoryAdded->amount;
    }
}
