<?php

namespace App\Domain\Order\Projections\States;

class CanceledOrderState extends OrderState
{
    public function label(): string
    {
        return 'Canceled';
    }

    public function color(): string
    {
        return 'text-red-500';
    }
}
