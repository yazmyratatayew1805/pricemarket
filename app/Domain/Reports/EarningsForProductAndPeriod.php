<?php

namespace App\Domain\Reports;

use App\Domain\Order\DataTransferObjects\OrderLineData;
use App\Domain\Order\Events\OrderCreated;
use App\Domain\Product\Product;
use Illuminate\Support\Collection;
use Spatie\EventSourcing\EventHandlers\Projectors\EventQuery;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use Spatie\Period\Period;

class EarningsForProductAndPeriod extends EventQuery
{
    private int $totalPrice = 0;

    public function __construct(
        private Period $period,
        private Collection $products
    ) {
        /** @var \Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder $query */
        $query = EloquentStoredEvent::query();

        $query
            ->whereDate('created_at', '>=', $this->period->getStart())
            ->whereDate('created_at', '<=', $this->period->getEnd())
            ->whereEvent(OrderCreated::class)
            ->cursor()
            ->each(fn (EloquentStoredEvent $event) => $this->apply($event->toStoredEvent()));
    }

    public function totalPrice(): int
    {
        return $this->totalPrice;
    }

    protected function applyOrderCreated(
        OrderCreated $orderCreated
    ): void {
        if (! $this->period->contains($orderCreated->createdAt)) {
            return;
        }

        $orderLines = collect($orderCreated->orderData->orderLineData);

        $totalPriceForOrder = $orderLines
            ->filter(function (OrderLineData $orderLineData) {
                return $this->products->first(fn (Product $product) => $orderLineData->productEquals($product)) !== null;
            })
            ->sum(fn (OrderLineData $orderLineData) => $orderLineData->totalPriceIncludingVat);

        $this->totalPrice += $totalPriceForOrder;
    }
}
