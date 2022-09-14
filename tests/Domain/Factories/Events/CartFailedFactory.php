<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Cart\Events\CartFailed;

class CartFailedFactory
{
    private string $cartUuid = 'cart-uuid';

    public static function new(): self
    {
        return new self();
    }

    public function create(): CartFailed
    {
        return new CartFailed($this->cartUuid);
    }

    public function withCartUuid(string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }
}
