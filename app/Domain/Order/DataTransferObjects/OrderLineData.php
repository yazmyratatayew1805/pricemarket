<?php

namespace App\Domain\Order\DataTransferObjects;

use App\Domain\Cart\Projections\CartItem;
use App\Domain\Product\Product;

class OrderLineData
{
    public function __construct(
        public string $uuid,
        public int $productId,
        public string $description,
        public int $amount,
        public int $pricePerItemExcludingVat,
        public int $pricePerItemIncludingVat,
        public int $vatPercentage,
        public int $vatPrice,
        public int $totalPriceExcludingVat,
        public int $totalPriceIncludingVat,
    ) {
    }

    public static function fromCartItem(CartItem $cartItem): self
    {
        return new self(
            uuid: $cartItem->uuid,
            productId: $cartItem->product->getKey(),
            description: $cartItem->product->getName(),
            amount: $cartItem->amount,
            pricePerItemExcludingVat: $cartItem->price_per_item_excluding_vat,
            pricePerItemIncludingVat: $cartItem->price_per_item_including_vat,
            vatPercentage: $cartItem->vat_percentage,
            vatPrice: $cartItem->vat_price,
            totalPriceExcludingVat: $cartItem->total_item_price_excluding_vat,
            totalPriceIncludingVat: $cartItem->total_item_price_including_vat,
        );
    }

    public function productEquals(Product $product): bool
    {
        return $product->id === $this->productId;
    }
}
