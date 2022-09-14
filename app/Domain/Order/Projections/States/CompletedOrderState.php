<?php

namespace App\Domain\Order\Projections\States;

class CompletedOrderState extends OrderState
{
    public function color(): string
    {
        return 'text-green-500';
    }

    public function label(): string
    {
        return 'Completed';
    }
}
