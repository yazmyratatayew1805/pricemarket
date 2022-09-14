<?php

namespace Tests\Domain\Order\Actions;

use App\Domain\Order\Actions\CompleteOrder;
use App\Domain\Order\Projections\States\CompletedOrderState;
use App\Domain\Order\Reactors\OrderPaymentPaidReactor;
use Carbon\Carbon;
use Spatie\EventSourcing\Projectionist;
use Tests\Domain\Factories\OrderAggregateFactory;
use Tests\Domain\Fakes\Order\Reactors\FakeOrderPaymentPaidReactor;
use Tests\TestCase;

class CompleteOrderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        app(Projectionist::class)->fake(OrderPaymentPaidReactor::class, FakeOrderPaymentPaidReactor::class);
    }

    /** @test */
    public function test_complete(): void
    {
        Carbon::setTestNow('2020-01-01');

        $order = OrderAggregateFactory::new()->create();

        $order = (new CompleteOrder)($order, 'path/to/invoice.pdf');

        $this->assertTrue($order->state->equals(CompletedOrderState::class));
        $this->assertTrue(Carbon::create('2020-01-01')->eq($order->completed_at));
        $this->assertEquals('path/to/invoice.pdf', $order->invoice_path);
    }
}
