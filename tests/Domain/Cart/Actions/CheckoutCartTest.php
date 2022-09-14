<?php

namespace Tests\Domain\Cart\Actions;

use App\Domain\Cart\Actions\CheckoutCart;
use App\Domain\Cart\Enums\CartStatus;
use Tests\Domain\Factories\CartAggregateFactory;
use Tests\Domain\Factories\CartCheckoutDataFactory;
use Tests\TestCase;

class CheckoutCartTest extends TestCase
{
    private CartAggregateFactory $cartFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->cartFactory = CartAggregateFactory::new();
    }

    /** @test */
    public function test_checkout(): void
    {
        $cart = $this->cartFactory->withProduct()->create();

        $cart = (new CheckoutCart)($cart, CartCheckoutDataFactory::new()->create());

        $this->assertTrue($cart->status->equals(CartStatus::checkedOut()));
    }

    /** @test */
    public function order_is_created_after_checkout(): void
    {
        $cart = $this->cartFactory->withProduct()->create();

        $cart = (new CheckoutCart)($cart, CartCheckoutDataFactory::new()->create());

        $this->assertNotNull($cart->order);

        $this->assertNotNull($cart->order->payment);
    }
}
