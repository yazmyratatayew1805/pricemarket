<?php

namespace App\Http\Controllers\Orders;

use App\Domain\Order\Projections\Order;

class OrderPdfController
{
    public function __invoke(Order $order)
    {
        if ($order->invoice_path) {
            return response()->file($order->invoice_path);
        }

        return view('orders.invoice_pending', [
            'order' => $order,
        ]);
    }
}
