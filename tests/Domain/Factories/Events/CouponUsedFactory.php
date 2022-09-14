<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Cart\Events\CouponUsed;

class CouponUsedFactory
{
    private string $cartUuid = 'cart-uuid';

    private string $code = 'code';

    private int $reduction = 20_00;

    public static function new(): self
    {
        return new self();
    }

    public function create(): CouponUsed
    {
        return new CouponUsed(
            cartUuid: $this->cartUuid,
            couponCode: $this->code,
            couponReduction: $this->reduction,
        );
    }

    public function withCartUuid(string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }
}
