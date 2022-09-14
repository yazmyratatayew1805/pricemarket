<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Cart\Events\CouponRemoved;

class CouponRemovedFactory
{
    private string $cartUuid = 'cart-uuid';

    public static function new(): self
    {
        return new self();
    }

    public function create(): CouponRemoved
    {
        return new CouponRemoved(
            cartUuid: $this->cartUuid,
        );
    }

    public function withCartUuid(string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }
}
