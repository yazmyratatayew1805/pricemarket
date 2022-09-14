<?php

namespace App\Domain\Payment\Actions;

use App\Domain\Payment\PaymentAggregateRoot;
use App\Domain\Payment\Projections\Payment;

class FailPayment
{
    public function __invoke(Payment $payment): Payment
    {
        $paymentUuid = $payment->uuid;

        PaymentAggregateRoot::retrieve($paymentUuid)
            ->fail()
            ->persist();

        return $payment->refresh();
    }
}
