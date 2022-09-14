<?php

namespace Tests\Domain\Factories\Events;

use App\Domain\Cart\Events\CartItemAdded;
use App\Domain\Product\Product;
use Tests\Domain\Factories\ProductFactory;

class CartItemAddedFactory
{
    private ?Product $product = null;

    private string $cartUuid = 'cart-uuid';

    private ?string $cartItemUuid = null;

    private int $amount = 1;

    public static function new(): self
    {
        return new self();
    }

    public function create(): CartItemAdded
    {
        $product = $this->product ?? ProductFactory::new()->create();

        return new CartItemAdded(
            cartUuid: $this->cartUuid,
            cartItemUuid: $this->cartItemUuid ?? 'cart-item-uuid',
            productId: $product->getKey(),
            amount: $this->amount,
            currentPrice: $product->getItemPrice(),
        );
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

    public function withProduct(Product $product): self
    {
        $clone = clone $this;

        $clone->product = $product;

        return $clone;
    }

    public function withAmount(int $amount): self
    {
        $clone = clone $this;

        $clone->amount = $amount;

        return $clone;
    }
}
