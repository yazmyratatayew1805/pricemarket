<?php

namespace App\Domain\Cart\Actions;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Projections\Cart;

class FailCart
{
    public function __invoke(Cart $cart)
    {
        $cartUuid = $cart->uuid;

        CartAggregateRoot::retrieve($cartUuid)
            ->fail()
            ->persist();

        return Cart::find($cartUuid);
    }
}
