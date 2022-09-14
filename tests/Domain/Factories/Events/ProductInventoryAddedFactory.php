<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Inventory\Events\ProductInventoryAdded;
use App\Domain\Product\Product;
use Tests\Domain\Factories\ProductFactory;

class ProductInventoryAddedFactory
{
    private string $inventoryUuid = 'inventory-uuid';

    private ?Product $product = null;

    private int $amount = 1;

    public static function new(): self
    {
        return new self();
    }

    public function create(): ProductInventoryAdded
    {
        $product = $this->product ?? ProductFactory::new()->create();

        return new ProductInventoryAdded(
            inventoryUuid: $this->inventoryUuid,
            productId: $product->getKey(),
            amount: $this->amount,
        );
    }

    public function withInventoryUuid(string $inventoryUuid): self
    {
        $clone = clone $this;

        $clone->inventoryUuid = $inventoryUuid;

        return $clone;
    }

    public function withProduct(Product $product): self
    {
        $clone = clone $this;

        $clone->product = $product;

        return $clone;
    }

    public function withAmount(int $amount): self
    {
        $clone = clone $this;

        $clone->amount = $amount;

        return $clone;
    }
}
