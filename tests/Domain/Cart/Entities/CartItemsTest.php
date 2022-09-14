<?php

namespace Tests\Domain\Cart\Entities;

use App\Domain\Cart\Partials\CartItems;
use Tests\Domain\Factories\ProductFactory;
use Tests\TestCase;

class CartItemsTest extends TestCase
{
    private const CART_ITEM_UUID = 'cart-item-uuid';

    /** @test */
    public function test_is_empty(): void
    {
        $cartItems = CartItems::fake();

        $this->assertTrue($cartItems->isEmpty());

        $product = ProductFactory::new()->create();

        $cartItems->addItem(
            self::CART_ITEM_UUID,
            $product,
            1
        );

        $this->assertFalse($cartItems->isEmpty());
    }
}
