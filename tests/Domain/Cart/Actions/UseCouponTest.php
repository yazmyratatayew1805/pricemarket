<?php

namespace Tests\Domain\Cart\Actions;

use App\Domain\Cart\Actions\UseCoupon;
use App\Domain\Coupon\Coupon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\Domain\Factories\CartAggregateFactory;
use Tests\TestCase;

class UseCouponTest extends TestCase
{
    /** @test */
    public function use_coupon(): void
    {
        /** @var \App\Domain\Coupon\Coupon $coupon */
        $coupon = Coupon::factory()->create();

        $cart = CartAggregateFactory::new()->create();

        (new UseCoupon)($cart, $coupon->code);

        $cart->refresh();

        $this->assertEquals($coupon->code, $cart->coupon_code);
        $this->assertEquals($coupon->reduction, $cart->coupon_reduction);
    }

    /** @test */
    public function cannot_use_unknown_coupon(): void
    {
        $cart = CartAggregateFactory::new()->create();

        $this->assertExceptionThrown(function () use ($cart): void {
            (new UseCoupon)($cart, 'unknown');
        }, ModelNotFoundException::class);
    }
}
