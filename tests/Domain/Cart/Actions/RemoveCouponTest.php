<?php

namespace Tests\Domain\Cart\Actions;

use App\Domain\Cart\Actions\RemoveCoupon;
use App\Domain\Coupon\Coupon;
use Tests\Domain\Factories\CartAggregateFactory;
use Tests\TestCase;

class RemoveCouponTest extends TestCase
{
    /** @test */
    public function use_coupon(): void
    {
        /** @var \App\Domain\Coupon\Coupon $coupon */
        $coupon = Coupon::factory()->create();

        $cart = CartAggregateFactory::new()
            ->withCoupon($coupon)
            ->create();

        (new RemoveCoupon)($cart);

        $cart->refresh();

        $this->assertNull($cart->coupon_code);
        $this->assertNull($cart->coupon_reduction);
    }
}
