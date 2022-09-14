<?php

namespace App\Domain\Cart\Actions;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Projections\Cart;
use App\Domain\Cart\Projections\CartItem;
use App\Domain\Inventory\Exceptions\InsufficientInventoryAvailable;
use App\Domain\Product\Product;
use App\Support\Uuid;

class AddCartItem
{
    public function __invoke(Cart $cart, Product $product, int $amount): CartItem
    {
        $cartUuid = $cart->uuid;

        $cartItemUuid = Uuid::new();

        if ($product->managesInventory() && $product->hasAvailableInventory($amount) === false) {
            throw new InsufficientInventoryAvailable($product);
        }

        CartAggregateRoot::retrieve($cartUuid)
            ->addItem(
                cartItemUuid: $cartItemUuid,
                product: $product,
                amount: $amount,
            )
            ->persist();

        /** @var \App\Domain\Cart\Projections\CartItem $cartItem */
        $cartItem = $cart->items()->find($cartItemUuid);

        return $cartItem;
    }
}
