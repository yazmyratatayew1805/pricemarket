<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Cart\Events\CartInitialized;
use App\Domain\Customer\Customer;
use Tests\Domain\Factories\CustomerFactory;

class CartInitializedFactory
{
    private ?Customer $customer = null;

    private ?string $cartUuid = null;

    public static function new(): self
    {
        return new self();
    }

    public function create(): CartInitialized
    {
        $customer = $this->customer ?? CustomerFactory::new()->create();

        return new CartInitialized(
            cartUuid: $this->cartUuid ?? 'cart-uuid',
            customerId: $customer->getKey(),
            date: now(),
        );
    }

    public function withCartUuid(string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }

    public function withCustomer(Customer $customer): self
    {
        $clone = clone $this;

        $clone->customer = $customer;

        return $clone;
    }
}
