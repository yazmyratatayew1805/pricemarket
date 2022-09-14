<?php

namespace App\Domain\Order\Projections\States;

class PendingPaymentOrderState extends OrderState
{
    public function label(): string
    {
        return 'Pending';
    }
}
