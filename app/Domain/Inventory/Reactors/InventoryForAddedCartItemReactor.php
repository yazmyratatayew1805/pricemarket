<?php

namespace App\Domain\Inventory\Reactors;

use App\Domain\Cart\Events\CartItemAdded;
use App\Domain\Inventory\Commands\RemoveProductInventory;
use App\Domain\Product\Product;
use Spatie\EventSourcing\Commands\CommandBus;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class InventoryForAddedCartItemReactor extends Reactor
{
    public function __construct(private CommandBus $bus)
    {
    }

    public function onCartItemAdded(CartItemAdded $cartItemAdded): void
    {
        /** @var \App\Domain\Product\Product $product */
        $product = Product::find($cartItemAdded->productId);

        if (! $product->managesInventory()) {
            return;
        }

        $this->bus->dispatch(new RemoveProductInventory(
            $product->uuid,
            $product,
            $cartItemAdded->amount,
        ));
    }
}
