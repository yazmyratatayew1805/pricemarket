<?php

namespace App\Domain\Inventory\Projectors;

use App\Domain\Inventory\Events\ProductInventoryAdded;
use App\Domain\Inventory\Events\ProductInventoryRemoved;
use App\Domain\Inventory\Projections\Inventory;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class InventoryProjector extends Projector
{
    public function onProductInventoryAdded(ProductInventoryAdded $productInventoryAdded): void
    {
        /** @var Inventory|null $inventory */
        $inventory = Inventory::find($productInventoryAdded->inventoryUuid);

        if (! $inventory) {
            $inventory = (new Inventory)->writeable()->create([
                'uuid' => $productInventoryAdded->inventoryUuid,
                'product_id' => $productInventoryAdded->productId,
                'amount' => 0,
            ]);
        }

        /** @var \App\Domain\Inventory\Projections\Inventory $inventory */
        $inventory->writeable()->update([
            'amount' => $inventory->amount + $productInventoryAdded->amount,
        ]);
    }

    public function onProductInventoryRemoved(ProductInventoryRemoved $productInventoryRemoved): void
    {
        /** @var \App\Domain\Inventory\Projections\Inventory $inventory */
        $inventory = Inventory::findOrFail($productInventoryRemoved->inventoryUuid);

        $inventory->writeable()->update([
            'amount' => $inventory->amount - $productInventoryRemoved->amount,
        ]);
    }
}
