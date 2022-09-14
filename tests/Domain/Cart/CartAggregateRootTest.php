<?php

namespace Tests\Domain\Cart;

use App\Domain\Cart\CartAggregateRoot;
use App\Domain\Cart\Exceptions\CannotChangeCart;
use App\Domain\Cart\Exceptions\CannotUseCoupon;
use App\Domain\Cart\Exceptions\CartIsEmpty;
use App\Domain\Cart\Exceptions\NoCouponPresent;
use App\Domain\Cart\Exceptions\UnknownCartItem;
use App\Domain\Coupon\Coupon;
use App\Domain\Customer\Customer;
use App\Domain\Product\Price;
use App\Domain\Product\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tests\Domain\Factories\CartCheckoutDataFactory;
use Tests\Domain\Factories\CustomerFactory;
use Tests\Domain\Factories\Events\CartCheckedOutFactory;
use Tests\Domain\Factories\Events\CartInitializedFactory;
use Tests\Domain\Factories\Events\CartItemAddedFactory;
use Tests\Domain\Factories\Events\CartItemRemovedFactory;
use Tests\Domain\Factories\Events\CouponRemovedFactory;
use Tests\Domain\Factories\Events\CouponUsedFactory;
use Tests\Domain\Factories\Events\ShippingCostsAddedFactory;
use Tests\Domain\Factories\Events\ShippingCostsRemovedFactory;
use Tests\Domain\Factories\ProductFactory;
use Tests\Domain\Factories\Projections\CartItemFactory;
use Tests\TestCase;

class CartAggregateRootTest extends TestCase
{
    private const CART_UUID = 'cart-uuid';

    private const CART_ITEM_UUID = 'cart-item-uuid';

    private Model | Customer $customer;

    private Product $product;

    private CartInitializedFactory $cartInitializedFactory;

    private CartItemAddedFactory $cartItemAddedFactory;

    private CartCheckedOutFactory $cartCheckedOutFactory;

    private CartItemRemovedFactory $cartItemRemovedFactory;

    private ShippingCostsAddedFactory $shippingCostsAddedFactory;

    private ShippingCostsRemovedFactory $shippingCostsRemovedFactory;

    private CouponUsedFactory $couponUsedFactory;

    private CouponRemovedFactory $couponRemovedFactory;

    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2020-01-01');

        $this->customer = CustomerFactory::new()->create();

        $this->product = ProductFactory::new()->create();

        $this->cartInitializedFactory = CartInitializedFactory::new()
            ->withCartUuid(self::CART_UUID)
            ->withCustomer($this->customer);

        $this->cartItemAddedFactory = CartItemAddedFactory::new()
            ->withCartUuid(self::CART_UUID)
            ->withCartItemUuid(self::CART_ITEM_UUID)
            ->withProduct($this->product);

        $this->cartItemRemovedFactory = CartItemRemovedFactory::new()
            ->withCartUuid(self::CART_UUID)
            ->withCartItemUuid(self::CART_ITEM_UUID);

        $this->cartCheckedOutFactory = CartCheckedOutFactory::new()
            ->withCartUuid(self::CART_UUID);

        $this->shippingCostsAddedFactory = ShippingCostsAddedFactory::new()
            ->withCartUuid(self::CART_UUID);

        $this->shippingCostsRemovedFactory = ShippingCostsRemovedFactory::new()
            ->withCartUuid(self::CART_UUID);

        $this->couponUsedFactory = CouponUsedFactory::new()
            ->withCartUuid(self::CART_UUID);

        $this->couponRemovedFactory = CouponRemovedFactory::new()
            ->withCartUuid(self::CART_UUID);
    }

    /** @test */
    public function can_initialize(): void
    {
        CartAggregateRoot::fake(self::CART_UUID)
            ->given([])
            ->when(function (CartAggregateRoot $cartAggregateRoot): void {
                $cartAggregateRoot->initialize($this->customer);
            })
            ->assertRecorded([
                $this->cartInitializedFactory->create(),
                $this->shippingCostsAddedFactory->withPrice(new Price(50_00, 0_00))->create(),
            ]);
    }

    /** @test */
    public function can_add_item(): void
    {
        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot): void {
                $cartAggregateRoot->addItem(
                    self::CART_ITEM_UUID,
                    $this->product,
                    1
                );
            })
            ->assertRecorded([
                $this->cartItemAddedFactory->create(),
            ]);
    }

    /** @test */
    public function cannot_add_item_when_checked_out(): void
    {
        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->cartItemAddedFactory->create(),
                $this->cartCheckedOutFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot): void {
                $this->assertExceptionThrown(
                    fn () => $cartAggregateRoot->addItem(
                        self::CART_ITEM_UUID,
                        $this->product,
                        1
                    ),
                    CannotChangeCart::class,
                );
            });
    }

    /** @test */
    public function can_remove_item(): void
    {
        $cartItem = CartItemFactory::new()
            ->withCartUuid(self::CART_UUID)
            ->withCartItemUuid(self::CART_ITEM_UUID)
            ->create();

        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->cartItemAddedFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot) use ($cartItem): void {
                $cartAggregateRoot->removeItem($cartItem);
            })
            ->assertRecorded([
                $this->cartItemRemovedFactory->withCartItem($cartItem)->create(),
            ]);
    }

    /** @test */
    public function cannot_remove_item_when_checked_out(): void
    {
        $cartItem = CartItemFactory::new()
            ->withCartUuid(self::CART_UUID)
            ->withCartItemUuid(self::CART_ITEM_UUID)
            ->create();

        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->cartItemAddedFactory->create(),
                $this->cartCheckedOutFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot) use ($cartItem): void {
                $this->assertExceptionThrown(
                    fn () => $cartAggregateRoot->removeItem($cartItem),
                    CannotChangeCart::class
                );
            });
    }

    /** @test */
    public function cannot_remove_item_when_item_not_added(): void
    {
        $cartItem = CartItemFactory::new()
            ->withCartUuid(self::CART_UUID)
            ->withCartItemUuid(self::CART_ITEM_UUID)
            ->create();

        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->cartItemAddedFactory->withCartItemUuid('other-cart-item-uuid')->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot) use ($cartItem): void {
                $this->assertExceptionThrown(
                    fn () => $cartAggregateRoot->removeItem($cartItem),
                    UnknownCartItem::class
                );
            });
    }

    /** @test */
    public function can_checkout(): void
    {
        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->cartItemAddedFactory->withCartItemUuid(self::CART_ITEM_UUID)->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot): void {
                $cartAggregateRoot->checkout(CartCheckoutDataFactory::new()->create());
            })
            ->assertRecorded([
                $this->cartCheckedOutFactory->create(),
            ]);
    }

    /** @test */
    public function cannot_checkout_when_already_checked_out(): void
    {
        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->cartItemRemovedFactory->create(),
                $this->cartCheckedOutFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot): void {
                $this->assertExceptionThrown(
                    fn () => $cartAggregateRoot->checkout(CartCheckoutDataFactory::new()->create()),
                    CannotChangeCart::class
                );
            });
    }

    /** @test */
    public function cannot_checkout_when_no_items_in_cart(): void
    {
        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot): void {
                $this->assertExceptionThrown(
                    fn () => $cartAggregateRoot->checkout(CartCheckoutDataFactory::new()->create()),
                    CartIsEmpty::class
                );
            });
    }

    /** @test */
    public function shipping_costs_are_removed_when_threshold_is_reached(): void
    {
        $product = ProductFactory::new()->withItemPrice(100_00)->create();

        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->shippingCostsAddedFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot) use ($product): void {
                $cartAggregateRoot->addItem(
                    self::CART_ITEM_UUID,
                    $product,
                    3
                );
            })
            ->assertRecorded([
                $this->cartItemAddedFactory->withAmount(3)->withProduct($product)->create(),
                $this->shippingCostsRemovedFactory->create(),
            ]);
    }

    /** @test */
    public function shipping_costs_are_added_again_if_price_drops_below_threshold(): void
    {
        $product = ProductFactory::new()->withItemPrice(150_00)->create();

        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->shippingCostsAddedFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot) use ($product): void {
                $cartAggregateRoot->addItem('1', $product, 1);

                $cartAggregateRoot->addItem('2', $product, 1);

                $cartItem = CartItemFactory::new()->create([
                    'uuid' => '2',
                    'total_item_price_excluding_vat' => 150_00,
                    'total_item_price_including_vat' => 150_00,
                ]);

                $cartAggregateRoot->removeItem($cartItem);
            })
            ->assertRecorded([
                $this->cartItemAddedFactory
                    ->withProduct($product)
                    ->withCartItemUuid('1')
                    ->create(),
                $this->cartItemAddedFactory
                    ->withProduct($product)
                    ->withCartItemUuid('2')
                    ->create(),
                $this->shippingCostsRemovedFactory->create(),
                $this->cartItemRemovedFactory
                    ->withCartItemUuid('2')
                    ->withPriceExcludingVat(150_00)
                    ->withPriceIncludingVat(150_00)
                    ->create(),
                $this->shippingCostsAddedFactory->create(),
            ]);
    }

    /** @test */
    public function use_coupon(): void
    {
        /** @var \App\Domain\Coupon\Coupon $coupon */
        $coupon = Coupon::factory()->create();

        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot) use ($coupon): void {
                $cartAggregateRoot->useCoupon($coupon);
            })
            ->assertRecorded([
                $this->couponUsedFactory->create(),
            ]);
    }

    /** @test */
    public function cannot_use_coupon_twice(): void
    {
        /** @var \App\Domain\Coupon\Coupon $coupon */
        $coupon = Coupon::factory()->create();

        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->couponUsedFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot) use ($coupon): void {
                $this->assertExceptionThrown(function () use ($coupon, $cartAggregateRoot): void {
                    $cartAggregateRoot->useCoupon($coupon);
                }, CannotUseCoupon::class);
            });
    }

    /** @test */
    public function cannot_use_coupon_when_checked_out(): void
    {
        /** @var \App\Domain\Coupon\Coupon $coupon */
        $coupon = Coupon::factory()->create();

        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->cartItemAddedFactory->create(),
                $this->cartCheckedOutFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot) use ($coupon): void {
                $this->assertExceptionThrown(function () use ($coupon, $cartAggregateRoot): void {
                    $cartAggregateRoot->useCoupon($coupon);
                }, CannotUseCoupon::class);
            });
    }

    /** @test */
    public function remove_coupon(): void
    {
        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->couponUsedFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot): void {
                $cartAggregateRoot->removeCoupon();
            })
            ->assertRecorded(
                $this->couponRemovedFactory->create(),
            );
    }

    /** @test */
    public function cannot_remove_coupon_when_none_present(): void
    {
        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot): void {
                $this->assertExceptionThrown(function () use ($cartAggregateRoot): void {
                    $cartAggregateRoot->removeCoupon();
                }, NoCouponPresent::class);
            });
    }

    /** @test */
    public function cannot_remove_coupon_when_checked_out(): void
    {
        CartAggregateRoot::fake(self::CART_UUID)
            ->given([
                $this->cartInitializedFactory->create(),
                $this->cartItemAddedFactory->create(),
                $this->couponUsedFactory->create(),
                $this->cartCheckedOutFactory->create(),
            ])
            ->when(function (CartAggregateRoot $cartAggregateRoot): void {
                $this->assertExceptionThrown(function () use ($cartAggregateRoot): void {
                    $cartAggregateRoot->removeCoupon();
                }, CannotChangeCart::class);
            });
    }
}
