<?php

namespace App\Domain\Payment\States;

use Spatie\ModelStates\State;

abstract class PaymentState extends State
{
    public function shouldBePaid(): bool
    {
        return false;
    }

    public function isPaid(): bool
    {
        return false;
    }
}
