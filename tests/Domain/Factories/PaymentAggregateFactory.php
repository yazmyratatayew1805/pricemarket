<?php

namespace Tests\Domain\Factories;

use App\Domain\Payment\Actions\CreatePayment;
use App\Domain\Payment\Projections\Payment;
use App\Domain\Product\Product;

class PaymentAggregateFactory
{
    private ?OrderAggregateFactory $orderAggregateFactory = null;

    private ?Product $product = null;

    private int $amount = 1;

    public static function new(): self
    {
        return new self();
    }

    public function create(): Payment
    {
        $orderAggregateFactory = $this->orderAggregateFactory ?? OrderAggregateFactory::new();

        if ($this->product) {
            $orderAggregateFactory = $orderAggregateFactory->withProduct(
                $this->product,
                $this->amount,
            );
        }

        $order = $orderAggregateFactory->create();

        $payment = (new CreatePayment())($order);

        return $payment;
    }

    public function withOrderAggregateFactory(OrderAggregateFactory $orderAggregateFactory): self
    {
        $clone = clone $this;

        $clone->orderAggregateFactory = $orderAggregateFactory;

        return $clone;
    }

    public function withProduct(Product $product, int $amount): self
    {
        $clone = clone $this;

        $clone->product = $product;
        $clone->amount = $amount;

        return $clone;
    }
}
