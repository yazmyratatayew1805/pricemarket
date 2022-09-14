<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Inventory\Commands\RemoveProductInventory;
use App\Domain\Product\Product;
use Spatie\EventSourcing\Commands\CommandBus;

class RemoveProductInventoryAction
{
    public function __construct(
        private CommandBus $bus
    ) {
    }

    public function __invoke(Product $product, int $amount): void
    {
        $this->bus->dispatch(new RemoveProductInventory(
            inventoryUuid: $product->uuid,
            product: $product,
            amount: $amount
        ));
    }
}
