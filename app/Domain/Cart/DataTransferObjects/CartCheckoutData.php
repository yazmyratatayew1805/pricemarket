<?php

namespace App\Domain\Cart\DataTransferObjects;

class CartCheckoutData
{
    public function __construct(
        public string $street,
        public string $number,
        public string $postal,
        public string $city,
        public string $country,
    ) {
    }
}
