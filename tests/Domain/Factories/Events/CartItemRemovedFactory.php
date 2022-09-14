<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Cart\Events\CartItemRemoved;
use App\Domain\Cart\Projections\CartItem;
use Tests\Domain\Factories\ProductFactory;

class CartItemRemovedFactory
{
    private string $cartUuid = 'cart-uuid';

    private string $cartItemUuid = 'cart-item-uuid';

    private int $priceExcludingVat = 1;

    private int $priceIncludingVat = 1;

    public static function new(): self
    {
        return new self();
    }

    public function create(): CartItemRemoved
    {
        /** @var \App\Domain\Cart\Projections\CartItem $cartItem */
        $cartItem = CartItem::find($this->cartItemUuid);

        $product = $cartItem->product ?? ProductFactory::new()->create();

        return new CartItemRemoved(
            cartUuid: $this->cartUuid,
            cartItemUuid: $this->cartItemUuid,
            productId: $product->getKey(),
            amount: $cartItem->amount ?? 1,
            cartItemPriceExcludingVat: $this->priceExcludingVat,
            cartItemPriceIncludingVat: $this->priceIncludingVat,
        );
    }

    public function withPriceExcludingVat(int $priceExcludingVat): self
    {
        $clone = clone $this;

        $clone->priceExcludingVat = $priceExcludingVat;

        return $clone;
    }

    public function withPriceIncludingVat(int $priceIncludingVat): self
    {
        $clone = clone $this;

        $clone->priceIncludingVat = $priceIncludingVat;

        return $clone;
    }

    public function withCartUuid(string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }

    public function withCartItemUuid(string $cartItemUuid): self
    {
        $clone = clone $this;

        $clone->cartItemUuid = $cartItemUuid;

        return $clone;
    }

    public function withCartItem(CartItem $cartItem): self
    {
        $clone = clone $this;

        $clone->cartItemUuid = $cartItem->uuid;
        $clone->priceExcludingVat = $cartItem->total_item_price_excluding_vat;
        $clone->priceIncludingVat = $cartItem->total_item_price_including_vat;

        return $clone;
    }
}
