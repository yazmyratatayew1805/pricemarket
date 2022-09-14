<?php

namespace App\Http\Controllers\Cart;

use App\Domain\Cart\Actions\RemoveCartItem;
use App\Domain\Cart\Projections\CartItem;
use App\Domain\Customer\Customer;

class RemoveCartItemController
{
    public function __invoke(Customer $customer, CartItem $cartItem)
    {
        $cart = $customer->activeCart;

        (new RemoveCartItem)($cart, $cartItem);

        return redirect()->action(CartDetailController::class);
    }
}
