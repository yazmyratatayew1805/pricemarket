<?php

namespace App\Http\Controllers\Cart;

use App\Domain\Cart\Actions\RemoveCoupon;
use App\Domain\Customer\Customer;

class RemoveCouponController
{
    public function __invoke(Customer $customer)
    {
        $cart = $customer->activeCart;

        (new RemoveCoupon)($cart);

        return redirect()->action(CartDetailController::class, [$cart]);
    }
}
