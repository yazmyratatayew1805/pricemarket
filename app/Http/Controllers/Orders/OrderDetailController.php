<?php

namespace App\Http\Controllers\Orders;

use App\Domain\Order\Projections\Order;

class OrderDetailController
{
    public function __invoke(Order $order)
    {
        return view('orders.detail', [
            'order' => $order,
        ]);
    }
}
