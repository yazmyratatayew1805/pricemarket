<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Cart\Events\ShippingCostsAdded;
use App\Domain\Product\Price;

class ShippingCostsAddedFactory
{
    private string $cartUuid = 'cart-uuid';

    private ?Price $price = null;

    public static function new(): self
    {
        return new self();
    }

    public function create(): ShippingCostsAdded
    {
        return new ShippingCostsAdded(
            $this->cartUuid,
            $this->price ?? new Price(50_00, 0_00)
        );
    }

    public function withCartUuid(string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }

    public function withPrice(Price $price): self
    {
        $clone = clone $this;

        $clone->price = $price;

        return $clone;
    }
}
