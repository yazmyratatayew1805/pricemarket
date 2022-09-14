<?php

namespace App\Domain\Cart\Actions;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Projections\Cart;
use App\Domain\Coupon\Coupon;

class UseCoupon
{
    public function __invoke(Cart $cart, string $code)
    {
        $coupon = Coupon::where('code', $code)->firstOrFail();

        CartAggregateRoot::retrieve($cart->uuid)
            ->useCoupon($coupon)
            ->persist();

        return $cart->refresh();
    }
}
