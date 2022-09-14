<?php

namespace App\Domain\Payment\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PaymentCreated extends ShouldBeStored
{
    public function __construct(
        public string $paymentUuid,
        public string $orderUuid,
        public int $totalPriceIncludingVat
    ) {
    }
}
