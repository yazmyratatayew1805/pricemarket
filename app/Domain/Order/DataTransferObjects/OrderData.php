<?php

namespace App\Domain\Order\DataTransferObjects;

use App\Domain\Cart\Projections\Cart;
use App\Domain\Cart\Projections\CartItem;

/**
 * @property \App\Domain\Order\DataTransferObjects\OrderLineData[] $orderLineData
 */
class OrderData
{
    public function __construct(
        public string $cartUuid,
        public int $customerId,
        public int $totalPriceExcludingVat,
        public int $totalPriceIncludingVat,
        public ?int $shipping_costs_vat_percentage,
        public ?int $shipping_costs_excluding_vat,
        public ?int $shipping_costs_including_vat,
        public ?string $coupon_code,
        public ?int $coupon_reduction,
        public array $orderLineData,
    ) {
    }

    public static function fromCart(Cart $cart): self
    {
        return new self(
            cartUuid: $cart->uuid,
            customerId: $cart->customer->getKey(),
            totalPriceExcludingVat: $cart->total_item_price_excluding_vat,
            totalPriceIncludingVat: $cart->total_item_price_including_vat,
            shipping_costs_vat_percentage: $cart->shipping_costs_vat_percentage,
            shipping_costs_excluding_vat: $cart->shipping_costs_excluding_vat,
            shipping_costs_including_vat: $cart->shipping_costs_including_vat,
            coupon_code: $cart->coupon_code,
            coupon_reduction: $cart->coupon_reduction,
            orderLineData: $cart->items->map(fn (CartItem $cartItem) => OrderLineData::fromCartItem($cartItem))->toArray()
        );
    }
}
