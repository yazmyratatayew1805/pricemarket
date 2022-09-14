<?php

namespace Tests\Domain\Order\Actions;

use App\Domain\Order\Actions\FailOrder;
use App\Domain\Order\Projections\States\CanceledOrderState;
use App\Domain\Order\Reactors\OrderPaymentPaidReactor;
use Carbon\Carbon;
use Spatie\EventSourcing\Projectionist;
use Tests\Domain\Factories\OrderAggregateFactory;
use Tests\Domain\Fakes\Order\Reactors\FakeOrderPaymentPaidReactor;
use Tests\TestCase;

class FailOrderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        app(Projectionist::class)->fake(OrderPaymentPaidReactor::class, FakeOrderPaymentPaidReactor::class);
    }

    /** @test */
    public function test_fail(): void
    {
        Carbon::setTestNow('2020-01-01');

        $order = OrderAggregateFactory::new()->create();

        $order = (new FailOrder)($order);

        $this->assertTrue($order->state->equals(CanceledOrderState::class));
        $this->assertTrue(Carbon::create('2020-01-01')->eq($order->canceled_at));
    }
}
