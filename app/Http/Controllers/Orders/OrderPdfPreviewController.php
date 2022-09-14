<?php

namespace App\Http\Controllers\Orders;

use App\Domain\Order\Projections\Order;

class OrderPdfPreviewController
{
    public function __invoke(Order $order)
    {
        return view('orders.invoice', [
            'order' => $order,
        ]);
    }
}
