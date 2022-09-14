<?php

namespace Tests\Domain\Factories;

use App\Domain\Order\Projections\Order;
use App\Domain\Product\Product;
use Carbon\Carbon;

class OrderAggregateFactory
{
    private ?CartAggregateFactory $cartAggregateFactory = null;

    private array $products = [];

    private ?Carbon $date = null;

    public static function new(): self
    {
        return new self();
    }

    public function create(): Order
    {
        if ($this->date) {
            $now = now();

            Carbon::setTestNow($this->date);
        }

        $cartAggregateFactory = $this->cartAggregateFactory ?? CartAggregateFactory::new();

        if (count($this->products)) {
            foreach ($this->products as [$product, $amount]) {
                $cartAggregateFactory = $cartAggregateFactory->withProduct(
                    $product,
                    $amount,
                );
            }
        } else {
            $cartAggregateFactory = $cartAggregateFactory->withProduct();
        }

        $cart = $cartAggregateFactory
            ->checkedOut()
            ->create();

        if (isset($now)) {
            Carbon::setTestNow($now);
        }

        return $cart->refresh()->order;
    }

    public function withCartAggregateFactory(CartAggregateFactory $cartAggregateFactory): self
    {
        $clone = clone $this;

        $clone->cartAggregateFactory = $cartAggregateFactory;

        return $clone;
    }

    public function withProduct(Product $product, int $amount): self
    {
        $clone = clone $this;

        $clone->products[] = [$product, $amount];

        return $clone;
    }

    public function onDate(Carbon $date): self
    {
        $clone = clone $this;

        $clone->date = $date;

        return $clone;
    }
}
