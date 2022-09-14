<?php

namespace Tests\Domain\Order\Actions;

use App\Domain\Order\Actions\CreateOrder;
use App\Domain\Order\Projections\States\PendingPaymentOrderState;
use Carbon\Carbon;
use Tests\Domain\Factories\CartAggregateFactory;
use Tests\Domain\Factories\ProductFactory;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{
    /** @test */
    public function test_create_order(): void
    {
        Carbon::setTestNow('2020-01-01');

        $product = ProductFactory::new()->withItemPrice(10_00)->create();

        $cart = CartAggregateFactory::new()
            ->withProduct($product, 2)
            ->withProduct($product, 2)
            ->create();

        $order = (new CreateOrder)($cart);

        $this->assertEquals('ORDER-00001', $order->order_number);
        $this->assertEquals(4 * 10_00, $order->total_item_price_including_vat);
        $this->assertTrue($order->state->equals(PendingPaymentOrderState::class));
        $this->assertTrue(Carbon::make('2020-01-01')->eq($order->created_at));
    }

    /** @test */
    public function order_numbers_are_incremented(): void
    {
        $cart = CartAggregateFactory::new()->create();

        $orderA = (new CreateOrder)($cart);

        $this->assertEquals('ORDER-00001', $orderA->order_number);

        $orderB = (new CreateOrder)($cart);

        $this->assertEquals('ORDER-00002', $orderB->order_number);
    }
}
