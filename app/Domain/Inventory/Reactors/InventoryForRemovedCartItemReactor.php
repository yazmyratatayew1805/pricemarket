<?php

namespace App\Domain\Inventory\Reactors;

use App\Domain\Cart\Events\CartItemRemoved;
use App\Domain\Inventory\Commands\AddProductInventory;
use App\Domain\Product\Product;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class InventoryForRemovedCartItemReactor extends Reactor
{
    public function __construct(private CommandBus $bus)
    {
    }

    public function onCartItemRemoved(CartItemRemoved $cartItemRemoved): void
    {
        /** @var \App\Domain\Product\Product $product */
        $product = Product::find($cartItemRemoved->productId);

        if (! $product->managesInventory()) {
            return;
        }

        $this->bus->dispatch(new AddProductInventory(
            $product->uuid,
            $product,
            $cartItemRemoved->amount
        ));
    }
}
