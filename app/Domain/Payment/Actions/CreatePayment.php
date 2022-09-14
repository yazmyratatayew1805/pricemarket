<?php

namespace App\Domain\Payment\Actions;

use App\Domain\Order\Projections\Order;
use App\Domain\Payment\PaymentAggregateRoot;
use App\Domain\Payment\Projections\Payment;
use App\Support\Uuid;

class CreatePayment
{
    public function __invoke(Order $order): Payment
    {
        $paymentUuid = Uuid::new();

        PaymentAggregateRoot::retrieve($paymentUuid)
            ->create($order)
            ->persist();

        /** @var \App\Domain\Payment\Projections\Payment $payment */
        $payment = Payment::findOrFail($paymentUuid);

        return $payment;
    }
}
