<?php

namespace Tests\Domain\Factories;

use App\Domain\Inventory\Actions\AddProductInventoryAction;
use App\Domain\Inventory\Projections\Inventory;
use App\Domain\Product\Product;

class InventoryAggregateFactory
{
    private ?Product $product = null;

    private int $amount = 10;

    public static function new(): self
    {
        return new self();
    }

    public function create(): Inventory
    {
        $product = $this->product ?? ProductFactory::new()->create();

        return app(AddProductInventoryAction::class)($product, $this->amount);
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
