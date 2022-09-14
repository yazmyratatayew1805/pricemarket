<?php

namespace Tests\Domain\Payment\Actions;

use App\Domain\Payment\Actions\CreatePayment;
use App\Domain\Payment\States\OpenPaymentState;
use Tests\Domain\Factories\OrderAggregateFactory;
use Tests\Domain\Factories\ProductFactory;
use Tests\TestCase;

class CreatePaymentTest extends TestCase
{
    /** @test */
    public function test_create_payment(): void
    {
        $product = ProductFactory::new()->withItemPrice(10_00)->create();

        $order = OrderAggregateFactory::new()
            ->withProduct($product, 2)
            ->withProduct($product, 2)
            ->create();

        $payment = (new CreatePayment)($order);

        $this->assertEquals(4 * 10_00, $payment->total_item_price_including_vat);
        $this->assertTrue($payment->state->equals(OpenPaymentState::class));
    }
}
