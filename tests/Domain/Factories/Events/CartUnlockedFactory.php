<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Cart\Events\CartUnlocked;

class CartUnlockedFactory
{
    private string $cartUuid = 'cart-uuid';

    public static function new(): self
    {
        return new self();
    }

    public function create(): CartUnlocked
    {
        return new CartUnlocked($this->cartUuid);
    }

    public function withCartUuid(string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }
}
