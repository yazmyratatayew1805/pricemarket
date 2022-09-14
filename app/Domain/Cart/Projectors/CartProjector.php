<?php

namespace App\Domain\Cart\Projectors;

use App\Domain\Cart\Enums\CartLockStatus;
use App\Domain\Cart\Enums\CartStatus;
use App\Domain\Cart\Events\CartCheckedOut;
use App\Domain\Cart\Events\CartFailed;
use App\Domain\Cart\Events\CartInitialized;
use App\Domain\Cart\Events\CartItemAdded;
use App\Domain\Cart\Events\CartItemRemoved;
use App\Domain\Cart\Events\CartPaid;
use App\Domain\Cart\Events\CouponRemoved;
use App\Domain\Cart\Events\CouponUsed;
use App\Domain\Cart\Events\ShippingCostsAdded;
use App\Domain\Cart\Events\ShippingCostsRemoved;
use App\Domain\Cart\Projections\Cart;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class CartProjector extends Projector
{
    public function resetState(): void
    {
        Cart::query()->delete();
    }

    public function onCartInitialized(CartInitialized $event): void
    {
        (new Cart)->writeable()->create([
            'uuid' => $event->cartUuid,
            'status' => CartStatus::pending(),
            'lock_status' => CartLockStatus::unlocked(),
            'customer_id' => $event->customerId,
            'created_at' => $event->date,
        ]);
    }

    public function onCartItemAdded(CartItemAdded $event): void
    {
        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::find($event->cartUuid);

        $cart->writeable()->update([
            'total_item_price_excluding_vat' => $cart->total_item_price_excluding_vat + ($event->amount * $event->currentPrice->pricePerItemExcludingVat()),
            'total_item_price_including_vat' => $cart->total_item_price_including_vat + ($event->amount * $event->currentPrice->pricePerItemIncludingVat()),
        ]);
    }

    public function onCartItemRemoved(CartItemRemoved $event): void
    {
        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::find($event->cartUuid);

        $cart->writeable()->update([
            'total_item_price_excluding_vat' => $cart->total_item_price_excluding_vat - $event->cartItemPriceExcludingVat,
            'total_item_price_including_vat' => $cart->total_item_price_including_vat - $event->cartItemPriceIncludingVat,
        ]);
    }

    public function onCartCheckedOut(CartCheckedOut $event): void
    {
        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::find($event->cartUuid);

        $cart->writeable()->update([
            'status' => CartStatus::checkedOut(),
        ]);
    }

    public function onCartFailed(CartFailed $event): void
    {
        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::find($event->cartUuid);

        $cart->writeable()->update([
            'status' => CartStatus::failed(),
        ]);
    }

    public function onCartPaid(CartPaid $event): void
    {
        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::find($event->cartUuid);

        $cart->writeable()->update([
            'status' => CartStatus::paid(),
        ]);
    }

    public function onShippingCostsAdded(ShippingCostsAdded $event): void
    {
        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::find($event->cartUuid);

        $cart->writeable()->update([
            'shipping_costs_vat_percentage' => $event->shippingCost->vatPercentage(),
            'shipping_costs_excluding_vat' => $event->shippingCost->pricePerItemExcludingVat(),
            'shipping_costs_including_vat' => $event->shippingCost->pricePerItemIncludingVat(),
        ]);
    }

    public function onShippingCostsRemoved(ShippingCostsRemoved $event): void
    {
        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::find($event->cartUuid);

        $cart->writeable()->update([
            'shipping_costs_vat_percentage' => null,
            'shipping_costs_excluding_vat' => null,
            'shipping_costs_including_vat' => null,
        ]);
    }

    public function onCouponUsed(CouponUsed $event): void
    {
        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::find($event->cartUuid);

        $cart->writeable()->update([
            'coupon_code' => $event->couponCode,
            'coupon_reduction' => $event->couponReduction,
        ]);
    }

    public function onCouponRemoved(CouponRemoved $event): void
    {
        /** @var \App\Domain\Cart\Projections\Cart $cart */
        $cart = Cart::find($event->cartUuid);

        $cart->writeable()->update([
            'coupon_code' => null,
            'coupon_reduction' => null,
        ]);
    }
}
