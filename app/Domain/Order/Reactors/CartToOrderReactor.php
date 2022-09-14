<?php

namespace App\Domain\Order\Reactors;

use App\Domain\Cart\Actions\LockCart;
use App\Domain\Cart\Events\CartCheckedOut;
use App\Domain\Cart\Projections\Cart;
use App\Domain\Order\Actions\CreateOrder;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class CartToOrderReactor extends Reactor
{
    public function onCartCheckedOut(CartCheckedOut $event): void
    {
        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::find($event->cartUuid);

        $cart = (new LockCart)($cart);

        (new CreateOrder)($cart);
    }
}
