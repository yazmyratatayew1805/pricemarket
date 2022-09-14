<?php

namespace Tests\Domain\Payment\Actions;

use App\Domain\Order\Projections\States\CompletedOrderState;
use App\Domain\Order\Reactors\OrderPaymentPaidReactor;
use App\Domain\Payment\Actions\PayPayment;
use App\Domain\Payment\States\PaidPaymentState;
use Carbon\Carbon;
use Spatie\EventSourcing\Projectionist;
use Tests\Domain\Factories\PaymentAggregateFactory;
use Tests\Domain\Fakes\Order\Reactors\FakeOrderPaymentPaidReactor;
use Tests\TestCase;

class PayPaymentTest extends TestCase
{
    /** @test */
    public function test_pay_payment(): void
    {
        app(Projectionist::class)->fake(OrderPaymentPaidReactor::class, FakeOrderPaymentPaidReactor::class);

        Carbon::setTestNow('2020-01-01');

        $payment = PaymentAggregateFactory::new()->create();

        $payment = (new PayPayment)($payment);

        $this->assertTrue($payment->state->equals(PaidPaymentState::class));
        $this->assertTrue(Carbon::create('2020-01-01')->eq($payment->paid_at));
    }

    /** @test */
    public function order_is_completed(): void
    {
        $this->markTestSkipped("Browsershot takes a while");

        Carbon::setTestNow('2020-01-01');

        $payment = PaymentAggregateFactory::new()->create();

        $payment = (new PayPayment)($payment);

        $order = $payment->order;

        $this->assertTrue($order->state->equals(CompletedOrderState::class));
        $this->assertNotNull($order->invoice_path);
        $this->assertFileExists($order->invoice_path);
    }
}
