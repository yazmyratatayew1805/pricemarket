<?php

namespace App\Domain\Payment\Events;

use Carbon\Carbon;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class PaymentFailed extends ShouldBeStored
{
    public function __construct(
        public string $paymentUuid,
        public Carbon $failedAt,
    ) {
    }
}
