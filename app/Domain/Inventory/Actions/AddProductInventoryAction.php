<?php

namespace App\Domain\Inventory\Actions;

use App\Domain\Inventory\Commands\AddProductInventory;
use App\Domain\Inventory\Projections\Inventory;
use App\Domain\Product\Product;
use Spatie\EventSourcing\Commands\CommandBus;

class AddProductInventoryAction
{
    public function __construct(
        private CommandBus $bus
    ) {
    }

    public function __invoke(Product $product, int $amount): Inventory
    {
        $inventoryUuid = $product->getUuid();

        $this->bus->dispatch(new AddProductInventory(
            inventoryUuid: $inventoryUuid,
            product: $product,
            amount: $amount,
        ));

        /** @var \App\Domain\Inventory\Projections\Inventory $inventory */
        $inventory = Inventory::findOrFail($inventoryUuid);

        return $inventory;
    }
}
