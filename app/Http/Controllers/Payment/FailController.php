<?php

namespace App\Http\Controllers\Payment;

use App\Domain\Payment\Actions\FailPayment;
use App\Domain\Payment\Projections\Payment;
use App\Http\Controllers\Orders\OrderDetailController;

class FailController
{
    public function __invoke(Payment $payment)
    {
        (new FailPayment)($payment);

        return redirect()->action(OrderDetailController::class, [$payment->order]);
    }
}
