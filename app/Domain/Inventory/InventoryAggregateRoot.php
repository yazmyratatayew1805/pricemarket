<?php

namespace App\Domain\Inventory;

use App\Domain\Inventory\Commands\AddProductInventory;
use App\Domain\Inventory\Commands\RemoveProductInventory;
use App\Domain\Inventory\Events\ProductInventoryAdded;
use App\Domain\Inventory\Events\ProductInventoryRemoved;
use App\Domain\Inventory\Exceptions\InsufficientInventoryAvailable;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class InventoryAggregateRoot extends AggregateRoot
{
    private int $available = 0;

    public function addInventory(AddProductInventory $command): self
    {
        $this->recordThat(new ProductInventoryAdded(
            inventoryUuid: $this->uuid(),
            productId: $command->product->getKey(),
            amount: $command->amount,
        ));

        return $this;
    }

    protected function applyProductInventoryAdded(
        ProductInventoryAdded $productInventoryAdded
    ): void {
        $this->available += $productInventoryAdded->amount;
    }

    public function removeInventory(RemoveProductInventory $command): self
    {
        if ($this->available < $command->amount) {
            throw new InsufficientInventoryAvailable($command->product);
        }

        $this->recordThat(new ProductInventoryRemoved(
            inventoryUuid: $this->uuid(),
            productId: $command->product->getKey(),
            amount: $command->amount,
        ));

        return $this;
    }

    protected function applyProductInventoryRemoved(
        ProductInventoryRemoved $productInventoryRemoved
    ): void {
        $this->available -= $productInventoryRemoved->amount;
    }
}
