<?php

namespace App\Http\Controllers\Orders;

use App\Domain\Customer\Customer;
use App\Domain\Order\Projections\Order;

class OrderIndexController
{
    public function __invoke(Customer $customer)
    {
        $orders = Order::whereCustomer($customer)->orderByDesc('created_at')->paginate();

        return view('orders.index', [
            'customer' => $customer,
            'orders' => $orders,
        ]);
    }
}
