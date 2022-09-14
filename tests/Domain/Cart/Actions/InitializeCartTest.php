<?php

namespace Tests\Domain\Cart\Actions;

use App\Domain\Cart\Actions\InitializeCart;
use App\Domain\Cart\Enums\CartStatus;
use App\Domain\Cart\Projections\Cart;
use Tests\Domain\Factories\CustomerFactory;
use Tests\TestCase;

class InitializeCartTest extends TestCase
{
    /** @test */
    public function test_initialize(): void
    {
        $customer = CustomerFactory::new()->create();

        $cart = (new InitializeCart)($customer);

        $this->assertDatabaseHas((new Cart)->getTable(), [
            'customer_id' => $customer->getKey(),
        ]);

        $this->assertTrue($cart->customer->is($customer));
        $this->assertTrue($cart->status->equals(CartStatus::pending()));
    }
}
