<?php

namespace Tests\Domain\Factories;

use App\Domain\Cart\DataTransferObjects\CartCheckoutData;

class CartCheckoutDataFactory
{
    public static function new(): self
    {
        return new self();
    }

    public function create(): CartCheckoutData
    {
        return new CartCheckoutData(
            street: 'Street',
            number: 101,
            postal: 2000,
            city: 'City',
            country: 'BE',
        );
    }
}
