<?php

namespace App\Domain\Cart\Reactors;

use App\Domain\Cart\Actions\PayCart;
use App\Domain\Payment\Events\PaymentPaid;
use App\Domain\Payment\Projections\Payment;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class CartPaymentPaidReactor extends Reactor
{
    public function onPaymentPaid(PaymentPaid $event): void
    {
        /** @var Payment $payment */
        $payment = Payment::findOrFail($event->paymentUuid);

        (new PayCart)($payment->order->cart);
    }
}
