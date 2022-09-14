<?php

namespace Tests\Domain\Cart\Actions;

use App\Domain\Cart\Actions\AddCartItem;
use App\Domain\Cart\Actions\InitializeCart;
use App\Domain\Cart\Actions\RemoveCartItem;
use App\Domain\Cart\Projections\Cart;
use Tests\Domain\Factories\CustomerFactory;
use Tests\Domain\Factories\ProductFactory;
use Tests\TestCase;

class AddCartItemTest extends TestCase
{
    private Cart $cart;

    public function setUp(): void
    {
        parent::setUp();

        $customer = CustomerFactory::new()->create();

        $this->cart = (new InitializeCart)($customer);
    }

    /** @test */
    public function test_add_item(): void
    {
        $itemPrice = 5_00;

        $vatPercentage = 6_00;

        $amount = 2;

        $product = ProductFactory::new()
            ->withItemPrice($itemPrice)
            ->withVatPercentage($vatPercentage)
            ->create();

        $cartItem = (new AddCartItem)(
            cart: $this->cart,
            product: $product,
            amount: $amount,
        );

        $this->assertEquals(1, $this->cart->refresh()->items->count());

        $this->assertTrue($cartItem->product->is($product));
        $this->assertEquals($itemPrice, $cartItem->price_per_item_excluding_vat);
        $this->assertEquals($itemPrice + ($itemPrice * ($vatPercentage / 100)), $cartItem->price_per_item_including_vat);
        $this->assertEquals($amount * $itemPrice, $cartItem->total_item_price_excluding_vat);
        $this->assertEquals($amount * ($itemPrice + ($itemPrice * ($vatPercentage / 100))), $cartItem->total_item_price_including_vat);
        $this->assertEquals($itemPrice * ($vatPercentage / 100), $cartItem->vat_price);
        $this->assertEquals($vatPercentage, $cartItem->vat_percentage);
        $this->assertEquals($amount, $cartItem->amount);
    }

    /** @test */
    public function cart_total_price_is_updated(): void
    {
        $itemPrice = 5_00;

        $vatPercentage = 6_00;

        $amount = 2;

        $product = ProductFactory::new()
            ->withItemPrice($itemPrice)
            ->withVatPercentage($vatPercentage)
            ->create();

        $cartItemA = (new AddCartItem)(
            cart: $this->cart,
            product: $product,
            amount: $amount,
        );

        $cartItemB = (new AddCartItem)(
            cart: $this->cart,
            product: $product,
            amount: $amount,
        );

        $this->assertEquals(
            $cartItemA->total_item_price_excluding_vat + $cartItemB->total_item_price_excluding_vat,
            $this->cart->refresh()->total_item_price_excluding_vat
        );

        $this->assertEquals(
            $cartItemA->total_item_price_including_vat + $cartItemB->total_item_price_including_vat,
            $this->cart->refresh()->total_item_price_including_vat
        );
    }

    /** @test */
    public function adding_item_with_inventory_decreases_that_inventory(): void
    {
        $product = ProductFactory::new()
            ->withInventory(10)
            ->create();

        (new AddCartItem)(
            cart: $this->cart,
            product: $product,
            amount: 5,
        );

        $product->refresh();

        $this->assertEquals(5, $product->inventory->amount);
    }

    /** @test */
    public function removing_item_with_inventory_increases_that_inventory(): void
    {
        $product = ProductFactory::new()
            ->withInventory(10)
            ->create();

        $cartItem = (new AddCartItem)(
            cart: $this->cart,
            product: $product,
            amount: 5,
        );

        (new RemoveCartItem)(
            cart: $this->cart,
            cartItem: $cartItem,
        );

        $product->refresh();

        $this->assertEquals(10, $product->inventory->amount);
    }
}
