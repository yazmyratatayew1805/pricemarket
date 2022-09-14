<?php

namespace App\Domain\Payment\States;

class OpenPaymentState extends PaymentState
{
    public function shouldBePaid(): bool
    {
        return true;
    }
}
