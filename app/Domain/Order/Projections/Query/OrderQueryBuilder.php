<?php

namespace App\Domain\Order\Projections\Query;

use App\Domain\Customer\Customer;
use Illuminate\Database\Eloquent\Builder;

class OrderQueryBuilder extends Builder
{
    public function whereCustomer(Customer $customer): self
    {
        return $this->where('customer_id', $customer->id);
    }
}
