<?php

namespace App\Http\Controllers\Cart;

use App\Domain\Cart\Actions\UseCoupon;
use App\Domain\Customer\Customer;
use App\Http\Requests\Cart\UseCouponRequest;

class UseCouponController
{
    public function __invoke(UseCouponRequest $request, Customer $customer)
    {
        $validated = $request->validated();

        $cart = $customer->activeCart;

        (new UseCoupon)($cart, $validated['code']);

        return redirect()->action(CartDetailController::class, [$cart]);
    }
}
