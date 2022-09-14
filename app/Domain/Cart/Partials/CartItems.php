<?php

namespace App\Domain\Cart\Partials;

use App\Domain\Cart\Events\CartItemAdded;
use App\Domain\Cart\Events\CartItemRemoved;
use App\Domain\Cart\Exceptions\UnknownCartItem;
use App\Domain\Cart\Projections\CartItem;
use App\Domain\Inventory\Exceptions\InsufficientInventoryAvailable;
use App\Domain\Product\Product;
use Spatie\EventSourcing\AggregateRoots\AggregatePartial;

class CartItems extends AggregatePartial
{
    private array $cartItems = [];

    private int $totalPrice = 0_00;

    public function isEmpty(): bool
    {
        return count($this->cartItems) === 0;
    }

    public function totalPrice(): int
    {
        return $this->totalPrice;
    }

    public function addItem(string $cartItemUuid, Product $product, int $amount): self
    {
        if ($product->managesInventory() && $product->hasAvailableInventory($amount) === false) {
            throw new InsufficientInventoryAvailable($product);
        }

        $this->recordThat(new CartItemAdded(
            cartUuid: $this->aggregateRootUuid(),
            cartItemUuid: $cartItemUuid,
            productId: $product->getKey(),
            amount: $amount,
            currentPrice: $product->getItemPrice(),
        ));

        return $this;
    }

    protected function applyCartItemAdded(CartItemAdded $cartItemAdded): void
    {
        $this->cartItems[$cartItemAdded->cartItemUuid] = $cartItemAdded->totalPrice();

        $this->totalPrice = array_sum($this->cartItems);
    }

    public function removeItem(CartItem $cartItem): self
    {
        if (! array_key_exists($cartItem->uuid, $this->cartItems)) {
            throw new UnknownCartItem();
        }

        $product = $cartItem->product;

        $this->recordThat(new CartItemRemoved(
            cartUuid: $this->aggregateRootUuid(),
            cartItemUuid: $cartItem->uuid,
            productId: $product->getKey(),
            amount: $cartItem->amount,
            cartItemPriceExcludingVat: $cartItem->total_item_price_excluding_vat,
            cartItemPriceIncludingVat: $cartItem->total_item_price_including_vat,
        ));

        return $this;
    }

    protected function applyCartItemRemoved(CartItemRemoved $cartItemRemoved): void
    {
        unset($this->cartItems[$cartItemRemoved->cartItemUuid]);

        $this->totalPrice = array_sum($this->cartItems);
    }
}
