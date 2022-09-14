<?php

namespace App\Domain\Cart\Actions;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Projections\Cart;

class LockCart
{
    public function __invoke(Cart $cart): Cart
    {
        CartAggregateRoot::retrieve($cart->uuid)
            ->lock()
            ->persist();

        return $cart->refresh();
    }
}
