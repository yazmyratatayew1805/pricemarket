<?php

namespace App\Domain\Cart\Actions;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Projections\Cart;
use App\Domain\Cart\Projections\CartItem;

class RemoveCartItem
{
    public function __invoke(Cart $cart, CartItem $cartItem): Cart
    {
        CartAggregateRoot::retrieve($cart->uuid)
            ->removeItem($cartItem)
            ->persist();

        return $cart->refresh();
    }
}
