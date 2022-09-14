<?php

namespace App\Domain\Cart\Actions;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Projections\Cart;

class UnlockCart
{
    public function __invoke(Cart $cart): Cart
    {
        CartAggregateRoot::retrieve($cart->uuid)
            ->unlock()
            ->persist();

        return $cart->refresh();
    }
}
