<?php

namespace App\Domain\Inventory\Exceptions;

use App\Domain\Product\Product;
use App\Support\DomainException;

class InsufficientInventoryAvailable extends DomainException
{
    public function __construct(Product $product)
    {
        parent::__construct("Not enough available inventory for {$product->getName()}");
    }
}
