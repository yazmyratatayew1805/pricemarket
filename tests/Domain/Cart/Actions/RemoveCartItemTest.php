<?php

namespace Tests\Domain\Cart\Actions;

use App\Domain\Cart\Actions\AddCartItem;
use App\Domain\Cart\Actions\InitializeCart;
use App\Domain\Cart\Actions\RemoveCartItem;
use App\Domain\Cart\Projections\Cart;
use App\Domain\Product\Product;
use Tests\Domain\Factories\CustomerFactory;
use Tests\Domain\Factories\ProductFactory;
use Tests\TestCase;

class RemoveCartItemTest extends TestCase
{
    private Cart $cart;

    private Product $product;

    public function setUp(): void
    {
        parent::setUp();

        $customer = CustomerFactory::new()->create();

        $this->cart = (new InitializeCart)($customer);

        $this->product = ProductFactory::new()
            ->withItemPrice(10_00)
            ->withVatPercentage(0)
            ->create();
    }

    /** @test */
    public function rest_remove_item(): void
    {
        $cartItem = (new AddCartItem)(
            cart: $this->cart,
            product: $this->product,
            amount: 1,
        );

        $cart = (new RemoveCartItem)(
            cart: $this->cart,
            cartItem: $cartItem
        );

        $this->assertEquals(0, $cart->items->count());
    }

    /** @test */
    public function cart_total_price_is_updated(): void
    {
        $cartItemA = (new AddCartItem)(
            cart: $this->cart,
            product: $this->product,
            amount: 1,
        );

        $cartItemB = (new AddCartItem)(
            cart: $this->cart,
            product: $this->product,
            amount: 1,
        );

        $cart = (new RemoveCartItem)(
            cart: $this->cart,
            cartItem: $cartItemA
        );

        $this->assertEquals($cartItemB->total_item_price_excluding_vat, $cart->total_item_price_excluding_vat);
        $this->assertEquals($cartItemB->total_item_price_including_vat, $cart->total_item_price_including_vat);
    }
}
