<?php

namespace App\Http\Controllers\Cart;

use App\Domain\Cart\Actions\CheckoutCart;
use App\Domain\Cart\DataTransferObjects\CartCheckoutData;
use App\Domain\Customer\Customer;
use App\Http\Controllers\Orders\OrderIndexController;
use App\Http\Requests\Cart\CheckoutRequest;

class CheckoutController
{
    public function __invoke(Customer $customer, CheckoutRequest $checkoutRequest)
    {
        $checkoutData = new CartCheckoutData(...$checkoutRequest->validated());

        $customer->update($checkoutRequest->validated());

        (new CheckoutCart)($customer->activeCart, $checkoutData);

        return redirect()->action(OrderIndexController::class);
    }
}
