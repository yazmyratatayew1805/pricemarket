<?php

namespace App\Domain\Payment;

use App\Domain\Order\Projections\Order;
use App\Domain\Payment\Events\PaymentCreated;
use App\Domain\Payment\Events\PaymentFailed;
use App\Domain\Payment\Events\PaymentPaid;
use App\Domain\Payment\Exceptions\PaymentAlreadyCreated;
use App\Domain\Payment\Exceptions\PaymentAlreadyPaid;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class PaymentAggregateRoot extends AggregateRoot
{
    private bool $created = false;

    private bool $paid = false;

    public function create(Order $order): self
    {
        if ($this->created) {
            throw new PaymentAlreadyCreated();
        }

        $this->recordThat(new PaymentCreated(
            paymentUuid: $this->uuid(),
            orderUuid: $order->uuid,
            totalPriceIncludingVat: $order->total_item_price_including_vat,
        ));

        return $this;
    }

    protected function applyPaymentCreated(PaymentCreated $event): void
    {
        $this->created = true;
    }

    public function pay(): self
    {
        if ($this->paid) {
            throw new PaymentAlreadyPaid();
        }

        $this->recordThat(new PaymentPaid(
            paymentUuid: $this->uuid(),
            paidAt: now(),
        ));

        return $this;
    }

    protected function applyPaymentPaid(PaymentPaid $event): void
    {
        $this->paid = true;
    }

    public function fail(): self
    {
        if ($this->paid) {
            throw new PaymentAlreadyPaid();
        }

        $this->recordThat(new PaymentFailed(
            paymentUuid: $this->uuid(),
            failedAt: now(),
        ));

        return $this;
    }
}
