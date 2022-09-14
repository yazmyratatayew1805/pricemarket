<?php

namespace App\Domain\Payment\Projectors;

use App\Domain\Payment\Events\PaymentCreated;
use App\Domain\Payment\Events\PaymentFailed;
use App\Domain\Payment\Events\PaymentPaid;
use App\Domain\Payment\Projections\Payment;
use App\Domain\Payment\States\FailedPaymentState;
use App\Domain\Payment\States\OpenPaymentState;
use App\Domain\Payment\States\PaidPaymentState;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class PaymentProjector extends Projector
{
    public function onPaymentCreated(PaymentCreated $event): void
    {
        (new Payment)->writeable()->create([
            'uuid' => $event->paymentUuid,
            'order_uuid' => $event->orderUuid,
            'state' => OpenPaymentState::class,
            'total_item_price_including_vat' => $event->totalPriceIncludingVat,
        ]);
    }

    public function onPaymentPaid(PaymentPaid $event): void
    {
        /** @var \App\Domain\Payment\Projections\Payment $payment */
        $payment = Payment::find($event->paymentUuid);

        $payment->writeable()->update([
            'state' => PaidPaymentState::class,
            'paid_at' => $event->paidAt,
            'failed_at' => null,
        ]);
    }

    public function onPaymentFailed(PaymentFailed $event): void
    {
        /** @var \App\Domain\Payment\Projections\Payment $payment */
        $payment = Payment::find($event->paymentUuid);

        $payment->writeable()->update([
            'state' => FailedPaymentState::class,
            'failed_at' => $event->failedAt,
        ]);
    }
}
