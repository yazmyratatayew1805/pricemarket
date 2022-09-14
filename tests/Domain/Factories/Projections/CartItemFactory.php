<?php

namespace Tests\Domain\Factories\Projections;

use App\Domain\Cart\Projections\CartItem;
use App\Support\Uuid;
use Tests\Domain\Factories\CartAggregateFactory;
use Tests\Domain\Factories\ProductFactory;

class CartItemFactory
{
    private ?string $cartItemUuid = null;

    private ?string $cartUuid = null;

    private int $amount = 1;

    public static function new(): self
    {
        return new self();
    }

    public function create(array $extra = []): CartItem
    {
        $product = ProductFactory::new()->create();

        $price = $product->getItemPrice();

        $cart = CartAggregateFactory::new()
            ->withCartUuid($this->cartUuid)
            ->create();

        return (new CartItem)->writeable()->create($extra + [
            'uuid' => $this->cartItemUuid ?? Uuid::new(),
            'cart_uuid' => $cart->uuid,
            'product_id' => $product->getKey(),
            'amount' => $this->amount,
            'price_per_item_excluding_vat' => $price->pricePerItemExcludingVat(),
            'price_per_item_including_vat' => $price->pricePerItemIncludingVat(),
            'vat_percentage' => $price->vatPercentage(),
            'vat_price' => $price->vatPrice(),
            'total_item_price_excluding_vat' => $this->amount * $price->pricePerItemExcludingVat(),
            'total_item_price_including_vat' => $this->amount * $price->pricePerItemIncludingVat(),
        ]);
    }

    public function withCartItemUuid(string $cartItemUuid): self
    {
        $clone = clone $this;

        $clone->cartItemUuid = $cartItemUuid;

        return $clone;
    }

    public function withCartUuid(string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }
}
