<?php

namespace App\Domain\Order\Reactors;

use App\Domain\Order\Actions\FailOrder;
use App\Domain\Payment\Events\PaymentFailed;
use App\Domain\Payment\Projections\Payment;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class PaymentForOrderFailedReactor extends Reactor
{
    public function onPaymentFailed(PaymentFailed $event): void
    {
        /** @var \App\Domain\Payment\Projections\Payment $payment */
        $payment = Payment::find($event->paymentUuid);

        (new FailOrder)($payment->order);
    }
}
