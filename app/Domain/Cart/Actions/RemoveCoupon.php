<?php

namespace App\Domain\Cart\Actions;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Projections\Cart;

class RemoveCoupon
{
    public function __invoke(Cart $cart)
    {
        CartAggregateRoot::retrieve($cart->uuid)
            ->removeCoupon()
            ->persist();

        return $cart->refresh();
    }
}
