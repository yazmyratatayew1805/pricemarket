<?php

namespace Tests\Domain\Factories;

use App\Domain\Product\Product;
use App\Support\Uuid;

class ProductFactory
{
    private ?string $uuid = null;

    private int $itemPrice = 10_00;

    private int $vatPercentage = 0;

    private ?int $withInventoryAmount = null;

    public static function new(): self
    {
        return new self();
    }

    public function create(array $extra = []): Product
    {
        $product = Product::create(
            [
                'uuid' => $this->uuid ?? Uuid::new(),
                'name' => 'Product',
                'item_price' => $this->itemPrice,
                'vat_percentage' => $this->vatPercentage,
                'manages_inventory' => $this->withInventoryAmount !== null,
            ] + $extra
        );

        if ($this->withInventoryAmount !== null) {
            InventoryAggregateFactory::new()
                ->withProduct($product)
                ->withAmount($this->withInventoryAmount)
                ->create();
        }

        return $product->refresh();
    }

    public function withUuid(string $uuid): self
    {
        $clone = clone $this;

        $clone->uuid = $uuid;

        return $clone;
    }

    public function withItemPrice(int $itemPrice): self
    {
        $clone = clone $this;

        $clone->itemPrice = $itemPrice;

        return $clone;
    }

    public function withVatPercentage(int $vatPercentage): self
    {
        $clone = clone $this;

        $clone->vatPercentage = $vatPercentage;

        return $clone;
    }

    public function withInventory(int $amount = 10): self
    {
        $clone = clone $this;

        $clone->withInventoryAmount = $amount;

        return $clone;
    }
}
