<?php

namespace App\Domain\Order\Projectors;

use App\Domain\Order\Events\OrderCancelled;
use App\Domain\Order\Events\OrderCompleted;
use App\Domain\Order\Events\OrderCreated;
use App\Domain\Order\Projections\Order;
use App\Domain\Order\Projections\OrderLine;
use App\Domain\Order\Projections\States\CanceledOrderState;
use App\Domain\Order\Projections\States\CompletedOrderState;
use App\Domain\Order\Projections\States\PendingPaymentOrderState;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class OrderProjector extends Projector
{
    public function onOrderCreated(OrderCreated $event): void
    {
        /** @var \App\Domain\Order\Projections\Order $order */
        $order = (new Order)->writeable()->create([
            'uuid' => $event->orderUuid,
            'order_number' => $event->orderNumber,
            'state' => PendingPaymentOrderState::class,
            'cart_uuid' => $event->orderData->cartUuid,
            'customer_id' => $event->orderData->customerId,
            'total_item_price_excluding_vat' => $event->orderData->totalPriceExcludingVat,
            'total_item_price_including_vat' => $event->orderData->totalPriceIncludingVat,
            'shipping_costs_vat_percentage' => $event->orderData->shipping_costs_vat_percentage,
            'shipping_costs_excluding_vat' => $event->orderData->shipping_costs_excluding_vat,
            'shipping_costs_including_vat' => $event->orderData->shipping_costs_including_vat,
            'coupon_code' => $event->orderData->coupon_code,
            'coupon_reduction' => $event->orderData->coupon_reduction,
            'created_at' => $event->createdAt,
        ]);

        foreach ($event->orderData->orderLineData as $orderLineData) {
            (new OrderLine)->writeable()->create([
                'uuid' => $orderLineData->uuid,
                'order_uuid' => $order->uuid,
                'product_id' => $orderLineData->productId,
                'description' => $orderLineData->description,
                'amount' => $orderLineData->amount,
                'price_per_item_excluding_vat' => $orderLineData->pricePerItemExcludingVat,
                'price_per_item_including_vat' => $orderLineData->pricePerItemIncludingVat,
                'vat_percentage' => $orderLineData->vatPercentage,
                'vat_price' => $orderLineData->vatPrice,
                'total_item_price_excluding_vat' => $orderLineData->totalPriceExcludingVat,
                'total_item_price_including_vat' => $orderLineData->totalPriceIncludingVat,
            ]);
        }
    }

    public function onOrderCompleted(OrderCompleted $event): void
    {
        /** @var \App\Domain\Order\Projections\Order $order */
        $order = Order::find($event->orderUuid);

        $order->writeable()->update([
            'state' => CompletedOrderState::class,
            'invoice_path' => $event->invoicePath,
            'completed_at' => $event->completedAt,
            'canceled_at' => null,
        ]);
    }

    public function onOrderFailed(OrderCancelled $event): void
    {
        /** @var \App\Domain\Order\Projections\Order $order */
        $order = Order::find($event->orderUuid);

        $order->writeable()->update([
            'state' => CanceledOrderState::class,
            'canceled_at' => $event->canceledAt,
        ]);
    }
}
