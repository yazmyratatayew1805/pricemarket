<?php

namespace Tests\Domain\Factories;

use App\Domain\Cart\Actions\AddCartItem;
use App\Domain\Cart\Actions\CheckoutCart;
use App\Domain\Cart\Actions\UseCoupon;
use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Projections\Cart;
use App\Domain\Coupon\Coupon;
use App\Domain\Product\Product;
use App\Support\Uuid;
use Carbon\Carbon;

class CartAggregateFactory
{
    private ?CustomerFactory $customerFactory = null;

    private array $items = [];

    private ?Carbon $date = null;

    private ?string $cartUuid = null;

    private bool $checkedOut = false;

    private ?Coupon $coupon = null;

    public static function new(): self
    {
        return new self();
    }

    public function create(): Cart
    {
        $customer = ($this->customerFactory ?? CustomerFactory::new())->create();

        if ($this->date) {
            $now = now();

            Carbon::setTestNow($this->date);
        }

        $cartUuid = $this->cartUuid ?? Uuid::new();

        CartAggregateRoot::retrieve($cartUuid)
            ->initialize($customer)
            ->persist();

        $cart = Cart::find($cartUuid);

        foreach ($this->items as [$product, $amount]) {
            (new AddCartItem)($cart, $product, $amount);
        }

        if ($this->coupon) {
            (new UseCoupon)($cart, $this->coupon->code);
        }

        if ($this->checkedOut) {
            (new CheckoutCart)($cart, CartCheckoutDataFactory::new()->create());
        }

        if (isset($now)) {
            Carbon::setTestNow($now);
        }

        return $cart->refresh();
    }

    public function withCartUuid(?string $cartUuid): self
    {
        $clone = clone $this;

        $clone->cartUuid = $cartUuid;

        return $clone;
    }

    public function withProduct(?Product $product = null, int $amount = 1): self
    {
        $clone = clone $this;

        $clone->items[] = [
            $product ?? ProductFactory::new()->create(),
            $amount,
        ];

        return $clone;
    }

    public function onDate(Carbon $date): self
    {
        $clone = clone $this;

        $clone->date = $date;

        return $clone;
    }

    public function checkedOut(): self
    {
        $clone = clone $this;

        $clone->checkedOut = true;

        return $clone;
    }

    public function withCoupon(Coupon $coupon): self
    {
        $clone = clone $this;

        $clone->coupon = $coupon;

        return $clone;
    }
}
