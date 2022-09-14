<?php

namespace Tests\Domain\Cart\Projectors;

use App\Domain\Cart\Actions\AddCartItem;
use App\Domain\Cart\Actions\CheckoutCart;
use App\Domain\Cart\Actions\InitializeCart;
use App\Domain\Cart\Projections\CartDuration;
use Carbon\Carbon;
use Tests\Domain\Factories\CartCheckoutDataFactory;
use Tests\Domain\Factories\CustomerFactory;
use Tests\Domain\Factories\ProductFactory;
use Tests\TestCase;

class CartDurationProjectorTest extends TestCase
{
    /** @test */
    public function duration_is_projected(): void
    {
        $customer = CustomerFactory::new()->create();

        Carbon::setTestNow('2021-01-01 10:00:00');

        $cart = (new InitializeCart)($customer);

        (new AddCartItem)($cart, ProductFactory::new()->create(), 1);

        Carbon::setTestNow('2021-01-01 10:35:00');

        (new CheckoutCart)($cart, CartCheckoutDataFactory::new()->create());

        /** @var \App\Domain\Cart\Projections\CartDuration $cartDuration */
        $cartDuration = CartDuration::where('cart_uuid', $cart->uuid)->first();

        $this->assertNotNull($cartDuration);
        $this->assertEquals(35, $cartDuration->duration_in_minutes);
    }
}
