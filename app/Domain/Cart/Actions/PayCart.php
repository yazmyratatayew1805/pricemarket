<?php

namespace App\Domain\Cart\Actions;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Projections\Cart;

class PayCart
{
    public function __invoke(Cart $cart)
    {
        $cartUuid = $cart->uuid;

        CartAggregateRoot::retrieve($cartUuid)
            ->pay()
            ->persist();

        return Cart::find($cartUuid);
    }
}
