<?php

namespace App\Domain\Payment\States;

class PaidPaymentState extends PaymentState
{
    public function isPaid(): bool
    {
        return true;
    }
}
