<?php

namespace App\Domain\Payment\Actions;

use App\Domain\Payment\PaymentAggregateRoot;
use App\Domain\Payment\Projections\Payment;

class PayPayment
{
    public function __invoke(Payment $payment): Payment
    {
        $paymentUuid = $payment->uuid;

        PaymentAggregateRoot::retrieve($paymentUuid)
            ->pay()
            ->persist();

        return $payment->refresh();
    }
}
