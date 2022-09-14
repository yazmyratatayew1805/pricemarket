<?php

namespace Tests\Domain\Fakes\Order\Reactors;

use App\Domain\Order\Projections\Order;
use App\Domain\Order\Reactors\OrderPaymentPaidReactor;

class FakeOrderPaymentPaidReactor extends OrderPaymentPaidReactor
{
    protected function createInvoice(Order $order): string
    {
        return '';
    }
}
