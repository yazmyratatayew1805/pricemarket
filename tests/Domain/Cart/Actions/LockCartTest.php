<?php

namespace Tests\Domain\Cart\Actions;

use App\Domain\Cart\Actions\AddCartItem;
use App\Domain\Cart\Actions\LockCart;
use App\Domain\Cart\Actions\UnlockCart;
use App\Domain\Cart\Exceptions\CannotChangeCart;
use Tests\Domain\Factories\CartAggregateFactory;
use Tests\Domain\Factories\ProductFactory;
use Tests\TestCase;

class LockCartTest extends TestCase
{
    /** @test */
    public function test_lock_unlock(): void
    {
        $cart = CartAggregateFactory::new()->create();

        $cart = (new LockCart)($cart);

        $product = ProductFactory::new()->create();

        $this->assertExceptionThrown(function () use ($product, $cart): void {
            (new AddCartItem)($cart, $product, 1);
        }, CannotChangeCart::class);

        $cart = (new UnlockCart)($cart);

        (new AddCartItem)($cart, $product, 1);

        $this->assertCount(1, $cart->refresh()->items);
    }
}
