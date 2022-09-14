<?php

namespace App\Domain\Cart;

use App\Domain\Cart\DataTransferObjects\CartCheckoutData;
use App\Domain\Cart\Events\CartCheckedOut;
use App\Domain\Cart\Events\CartFailed;
use App\Domain\Cart\Events\CartInitialized;
use App\Domain\Cart\Events\CartLocked;
use App\Domain\Cart\Events\CartPaid;
use App\Domain\Cart\Events\CartUnlocked;
use App\Domain\Cart\Events\CouponRemoved;
use App\Domain\Cart\Events\CouponUsed;
use App\Domain\Cart\Events\ShippingCostsAdded;
use App\Domain\Cart\Events\ShippingCostsRemoved;
use App\Domain\Cart\Exceptions\CannotChangeCart;
use App\Domain\Cart\Exceptions\CannotFailCart;
use App\Domain\Cart\Exceptions\CannotLockCart;
use App\Domain\Cart\Exceptions\CannotPayCart;
use App\Domain\Cart\Exceptions\CannotUnlockCart;
use App\Domain\Cart\Exceptions\CannotUseCoupon;
use App\Domain\Cart\Exceptions\CartIsEmpty;
use App\Domain\Cart\Exceptions\NoCouponPresent;
use App\Domain\Cart\Partials\CartItems;
use App\Domain\Cart\Partials\CartStateMachine;
use App\Domain\Cart\Projections\CartItem;
use App\Domain\Coupon\Coupon;
use App\Domain\Customer\Customer;
use App\Domain\Product\Price;
use App\Domain\Product\Product;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CartAggregateRoot extends AggregateRoot
{
    private const SHIPPING_COSTS_EXCLUDING_VAT = 50_00;

    private const SHIPPING_COSTS_VAT_PERCENTAGE = 0;

    private const SHIPPING_COST_THRESHOLD = 200_00;

    protected CartItems $cartItems;

    protected CartStateMachine $state;

    private ?Price $shippingCost = null;

    public function __construct()
    {
        $this->state = new CartStateMachine($this);
        $this->cartItems = new CartItems($this);
    }

    public function initialize(Customer $customer): self
    {
        if (! $this->state->changesAllowed()) {
            throw new CannotChangeCart();
        }

        $this->recordThat(new CartInitialized(
            cartUuid: $this->uuid(),
            customerId: $customer->getKey(),
            date: now(),
        ));

        $this->recordThat(new ShippingCostsAdded(
            cartUuid: $this->uuid(),
            shippingCost: new Price(self::SHIPPING_COSTS_EXCLUDING_VAT, self::SHIPPING_COSTS_VAT_PERCENTAGE),
        ));

        return $this;
    }

    public function checkout(CartCheckoutData $cartCheckoutData): self
    {
        if (! $this->state->changesAllowed()) {
            throw new CannotChangeCart();
        }

        if ($this->cartItems->isEmpty()) {
            throw new CartIsEmpty();
        }

        $this->recordThat(new CartCheckedOut(
            $this->uuid(),
            $cartCheckoutData
        ));

        return $this;
    }

    public function addItem(string $cartItemUuid, Product $product, int $amount): self
    {
        if (! $this->state->changesAllowed()) {
            throw new CannotChangeCart();
        }

        $this->cartItems->addItem($cartItemUuid, $product, $amount);

        if (
            $this->shippingCost !== null
            && $this->cartItems->totalPrice() > self::SHIPPING_COST_THRESHOLD
        ) {
            $this->recordThat(new ShippingCostsRemoved(
                cartUuid: $this->uuid(),
            ));
        }

        return $this;
    }

    protected function applyShippingCostsRemoved(ShippingCostsRemoved $event): void
    {
        $this->shippingCost = null;
    }

    public function removeItem(CartItem $cartItem): self
    {
        if (! $this->state->changesAllowed()) {
            throw new CannotChangeCart();
        }

        $this->cartItems->removeItem($cartItem);

        if (
            $this->shippingCost === null
            && $this->cartItems->totalPrice() <= self::SHIPPING_COST_THRESHOLD
        ) {
            $this->recordThat(new ShippingCostsAdded(
                cartUuid: $this->uuid(),
                shippingCost: new Price(self::SHIPPING_COSTS_EXCLUDING_VAT, self::SHIPPING_COSTS_VAT_PERCENTAGE),
            ));
        }

        return $this;
    }

    protected function applyShippingCostsAdded(ShippingCostsAdded $event): void
    {
        $this->shippingCost = $event->shippingCost;
    }

    public function useCoupon(Coupon $coupon): self
    {
        if (! $this->state->canUseCoupon()) {
            throw new CannotUseCoupon();
        }

        $this->recordThat(new CouponUsed(
            cartUuid: $this->uuid(),
            couponCode: $coupon->code,
            couponReduction: $coupon->reduction
        ));

        return $this;
    }

    public function removeCoupon(): self
    {
        if (! $this->state->couponUsed()) {
            throw new NoCouponPresent();
        }

        if (! $this->state->isPending()) {
            throw new CannotChangeCart();
        }

        $this->recordThat(new CouponRemoved(
            cartUuid: $this->uuid()
        ));

        return $this;
    }

    public function lock(): self
    {
        if ($this->state->isLocked()) {
            throw new CannotLockCart();
        }

        $this->recordThat(new CartLocked($this->uuid()));

        return $this;
    }

    public function unlock(): self
    {
        if (! $this->state->isLocked()) {
            throw new CannotUnlockCart();
        }

        $this->recordThat(new CartUnlocked($this->uuid()));

        return $this;
    }

    public function fail(): self
    {
        if (! $this->state->canFail()) {
            throw new CannotFailCart();
        }

        $this->recordThat(new CartFailed($this->uuid()));

        return $this;
    }

    public function pay(): self
    {
        if (! $this->state->canPay()) {
            throw new CannotPayCart();
        }

        $this->recordThat(new CartPaid($this->uuid()));

        return $this;
    }
}
