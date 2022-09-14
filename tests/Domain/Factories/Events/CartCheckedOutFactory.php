<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Cart\Events\CartCheckedOut;
use Tests\Domain\Factories\CartCheckoutDataFactory;

class CartCheckedOutFactory
{
    private string $cartUuid = 'cart-uuid';

    public static function new(): self
    {
        return new self();
    }

    public function create(): CartCheckedOut
    {
        return new CartCheckedOut(
            cartUuid: $this->cartUuid,
            cartCheckoutData: CartCheckoutDataFactory::new()->create(),
        );
    }

    public function withCartUuid(string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }
}
