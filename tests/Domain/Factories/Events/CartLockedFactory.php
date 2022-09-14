<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Cart\Events\CartLocked;

class CartLockedFactory
{
    private string $cartUuid = 'cart-uuid';

    public static function new(): self
    {
        return new self();
    }

    public function create(): CartLocked
    {
        return new CartLocked($this->cartUuid);
    }

    public function withCartUuid(string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }
}
