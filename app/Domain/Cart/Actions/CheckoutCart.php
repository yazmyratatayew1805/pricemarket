<?php

namespace App\Domain\Cart\Actions;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\DataTransferObjects\CartCheckoutData;
use App\Domain\Cart\Projections\Cart;

class CheckoutCart
{
    public function __invoke(Cart $cart, CartCheckoutData $cartCheckoutData): Cart
    {
        CartAggregateRoot::retrieve($cart->uuid)
            ->checkout($cartCheckoutData)
            ->persist();

        return $cart->refresh();
    }
}
