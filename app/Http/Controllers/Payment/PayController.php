<?php

namespace App\Http\Controllers\Payment;

use App\Domain\Payment\Actions\PayPayment;
use App\Domain\Payment\Projections\Payment;
use App\Http\Controllers\Orders\OrderDetailController;

class PayController
{
    public function __invoke(Payment $payment)
    {
        (new PayPayment)($payment);

        return redirect()->action(OrderDetailController::class, [$payment->order]);
    }
}
