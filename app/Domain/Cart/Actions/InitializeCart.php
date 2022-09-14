<?php

namespace App\Domain\Cart\Actions;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Projections\Cart;
use App\Domain\Customer\Customer;
use App\Support\Uuid;

class InitializeCart
{
    public function __invoke(Customer $customer): Cart
    {
        $cartUuid = Uuid::new();

        CartAggregateRoot::retrieve($cartUuid)
            ->initialize($customer)
            ->persist();

        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::findOrFail($cartUuid);

        return $cart;
    }
}
