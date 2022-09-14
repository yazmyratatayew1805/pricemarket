<?php

namespace App\Domain\Cart\Partials;

use App\Domain\Cart\Enums\CartLockStatus;
use App\Domain\Cart\Enums\CartStatus;
use App\Domain\Cart\Events\CartCheckedOut;
use App\Domain\Cart\Events\CartFailed;
use App\Domain\Cart\Events\CartLocked;
use App\Domain\Cart\Events\CartUnlocked;
use App\Domain\Cart\Events\CouponRemoved;
use App\Domain\Cart\Events\CouponUsed;
use Spatie\EventSourcing\AggregateRoots\AggregatePartial;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class CartStateMachine extends AggregatePartial
{
    private CartStatus $cartState;

    private CartLockStatus $lockState;

    private bool $couponUsed = false;

    public function __construct(AggregateRoot $aggregateRoot)
    {
        parent::__construct($aggregateRoot);

        $this->cartState = CartStatus::pending();
        $this->lockState = CartLockStatus::unlocked();
    }

    public function changesAllowed(): bool
    {
        return $this->cartState->equals(CartStatus::pending())
            && $this->lockState->equals(CartLockStatus::unlocked());
    }

    public function isLocked(): bool
    {
        return $this->lockState->equals(CartLockStatus::locked());
    }

    public function canPay(): bool
    {
        return $this->cartState->equals(CartStatus::checkedOut());
    }

    public function canFail(): bool
    {
        return $this->cartState->equals(CartStatus::checkedOut());
    }

    public function isFailed(): bool
    {
        return $this->cartState->equals(CartStatus::failed());
    }

    public function isPending(): bool
    {
        return $this->cartState->equals(CartStatus::pending());
    }

    public function canUseCoupon(): bool
    {
        return $this->isPending()
            && $this->couponUsed === false;
    }

    public function couponUsed(): bool
    {
        return $this->couponUsed === true;
    }

    public function applyCouponAdded(CouponUsed $event): void
    {
        $this->couponUsed = true;
    }

    public function applyCouponRemoved(CouponRemoved $event): void
    {
        $this->couponUsed = false;
    }

    public function applyCheckout(CartCheckedOut $event): void
    {
        $this->cartState = CartStatus::checkedOut();
    }

    public function applyLock(CartLocked $event): void
    {
        $this->lockState = CartLockStatus::locked();
    }

    public function applyUnlock(CartUnLocked $event): void
    {
        $this->lockState = CartLockStatus::unlocked();
    }

    public function applyFail(CartFailed $event): void
    {
        $this->cartState = $this->isLocked()
            ? CartStatus::failed()
            : CartStatus::pending();
    }
}
