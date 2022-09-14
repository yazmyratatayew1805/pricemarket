<?php

namespace App\Http\Controllers\Cart;

use App\Domain\Cart\Actions\AddCartItem;
use App\Domain\Cart\Actions\InitializeCart;
use App\Domain\Customer\Customer;
use App\Domain\Product\Product;
use App\Http\Controllers\Products\ProductIndexController;

class AddCartItemController
{
    public function __invoke(Customer $customer, Product $product)
    {
        $cart = $customer->activeCart;

        if (! $cart) {
            $cart = (new InitializeCart)($customer);

            $customer->update([
                'active_cart_uuid' => $cart->uuid,
            ]);
        }

        (new AddCartItem)($cart, $product, 1);

        return redirect()->action(ProductIndexController::class);
    }
}
