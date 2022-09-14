<?php

namespace App\Http\Controllers\Cart;

use App\Domain\Customer\Customer;
use App\Domain\Product\Product;

class CartDetailController
{
    public function __invoke(Customer $customer, Product $product)
    {
        return view('cart.detail', [
            'cart' => $customer->activeCart,
            'customer' => $customer,
        ]);
    }
}
