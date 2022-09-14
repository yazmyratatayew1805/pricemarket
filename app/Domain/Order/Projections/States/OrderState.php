<?php

namespace App\Domain\Order\Projections\States;

use App\Domain\Order\Projections\Order;
use Spatie\ModelStates\State;

abstract class OrderState extends State
{
    private Order $order;

    public function __construct(Order $model)
    {
        parent::__construct($model);

        $this->order = $model;
    }

    public function color(): string
    {
        return 'text-gray-500';
    }

    abstract public function label(): string;
}
