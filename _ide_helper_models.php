<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Domain\Cart\Projections{
/**
 * App\Domain\Cart\Projections\Cart
 *
 * @property string $uuid
 * @property int $customer_id
 * @property \App\Domain\Cart\Enums\CartStatus $status
 * @property \App\Domain\Cart\Enums\CartLockStatus $lock_status
 * @property int $total_item_price_excluding_vat
 * @property int $total_item_price_including_vat
 * @property int|null $shipping_costs_vat_percentage
 * @property int|null $shipping_costs_excluding_vat
 * @property int|null $shipping_costs_including_vat
 * @property string|null $coupon_code
 * @property int|null $coupon_reduction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Customer\Customer $customer
 * @property-read \App\Domain\Cart\Projections\Collections\CartItemCollection|\App\Domain\Cart\Projections\CartItem[] $items
 * @property-read int|null $items_count
 * @property-read \App\Domain\Order\Projections\Order|null $order
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCouponReduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereLockStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingCostsExcludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingCostsIncludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereShippingCostsVatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereTotalItemPriceExcludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereTotalItemPriceIncludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUuid($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Domain\Cart\Projections{
/**
 * App\Domain\Cart\Projections\CartDuration
 *
 * @property string $uuid
 * @property string $cart_uuid
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $checked_out_at
 * @property int|null $duration_in_minutes
 * @method static \Illuminate\Database\Eloquent\Builder|CartDuration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartDuration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartDuration query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartDuration whereCartUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDuration whereCheckedOutAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDuration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDuration whereDurationInMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartDuration whereUuid($value)
 */
	class CartDuration extends \Eloquent {}
}

namespace App\Domain\Cart\Projections{
/**
 * App\Domain\Cart\Projections\CartItem
 *
 * @property string $uuid
 * @property string $cart_uuid
 * @property int $product_id
 * @property int $amount
 * @property int $price_per_item_excluding_vat
 * @property int $price_per_item_including_vat
 * @property int $vat_percentage
 * @property int $vat_price
 * @property int $total_item_price_excluding_vat
 * @property int $total_item_price_including_vat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Cart\Projections\Cart $cart
 * @property-read \App\Domain\Product\Product $product
 * @method static \App\Domain\Cart\Projections\Collections\CartItemCollection|static[] all($columns = ['*'])
 * @method static \App\Domain\Cart\Projections\Collections\CartItemCollection|static[] get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereCartUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem wherePricePerItemExcludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem wherePricePerItemIncludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereTotalItemPriceExcludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereTotalItemPriceIncludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereVatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereVatPrice($value)
 */
	class CartItem extends \Eloquent {}
}

namespace App\Domain\Coupon{
/**
 * App\Domain\Coupon\Coupon
 *
 * @property int $id
 * @property string $code
 * @property int $reduction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereReduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Domain\Customer{
/**
 * App\Domain\Customer\Customer
 *
 * @property int $id
 * @property string|null $active_cart_uuid
 * @property string $name
 * @property string $email
 * @property int $user_id
 * @property string|null $street
 * @property string|null $number
 * @property string|null $postal
 * @property string|null $city
 * @property string|null $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Cart\Projections\Cart|null $activeCart
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Cart\Projections\Cart[] $carts
 * @property-read int|null $carts_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Order\Projections\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereActiveCartUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserId($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Domain\Inventory\Projections{
/**
 * App\Domain\Inventory\Projections\Inventory
 *
 * @property string $uuid
 * @property int $product_id
 * @property int $amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Product\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Inventory whereUuid($value)
 */
	class Inventory extends \Eloquent {}
}

namespace App\Domain\Order\Projections{
/**
 * App\Domain\Order\Projections\Order
 *
 * @property string $uuid
 * @property string $order_number
 * @property string $cart_uuid
 * @property int $customer_id
 * @property \App\Domain\Order\Projections\States\OrderState $state
 * @property int $total_item_price_excluding_vat
 * @property int $total_item_price_including_vat
 * @property int|null $shipping_costs_vat_percentage
 * @property int|null $shipping_costs_excluding_vat
 * @property int|null $shipping_costs_including_vat
 * @property string|null $coupon_code
 * @property int|null $coupon_reduction
 * @property string|null $invoice_path
 * @property \Illuminate\Support\Carbon|null $canceled_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Cart\Projections\Cart $cart
 * @property-read \App\Domain\Customer\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Order\Projections\OrderLine[] $lines
 * @property-read int|null $lines_count
 * @property-read \App\Domain\Payment\Projections\Payment|null $payment
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order newModelQuery()
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order newQuery()
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order query()
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereCanceledAt($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereCartUuid($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereCompletedAt($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereCouponCode($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereCouponReduction($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereCreatedAt($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereCustomer(\App\Domain\Customer\Customer $customer)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereCustomerId($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereInvoicePath($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereOrderNumber($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereShippingCostsExcludingVat($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereShippingCostsIncludingVat($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereShippingCostsVatPercentage($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereState($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereTotalItemPriceExcludingVat($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereTotalItemPriceIncludingVat($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereUpdatedAt($value)
 * @method static \App\Domain\Order\Projections\Query\OrderQueryBuilder|Order whereUuid($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Domain\Order\Projections{
/**
 * App\Domain\Order\Projections\OrderLine
 *
 * @property string $uuid
 * @property string $order_uuid
 * @property int $product_id
 * @property string $description
 * @property int $amount
 * @property int $price_per_item_excluding_vat
 * @property int $price_per_item_including_vat
 * @property int $vat_percentage
 * @property int $vat_price
 * @property int $total_item_price_excluding_vat
 * @property int $total_item_price_including_vat
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Order\Projections\Order $order
 * @property-read \App\Domain\Product\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereOrderUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine wherePricePerItemExcludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine wherePricePerItemIncludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereTotalItemPriceExcludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereTotalItemPriceIncludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereVatPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderLine whereVatPrice($value)
 */
	class OrderLine extends \Eloquent {}
}

namespace App\Domain\Payment\Projections{
/**
 * App\Domain\Payment\Projections\Payment
 *
 * @property string $uuid
 * @property string $order_uuid
 * @property \App\Domain\Payment\States\PaymentState $state
 * @property int $total_item_price_including_vat
 * @property \Illuminate\Support\Carbon|null $failed_at
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Order\Projections\Order $order
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereFailedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereOrderUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTotalItemPriceIncludingVat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUuid($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Domain\Product{
/**
 * App\Domain\Product\Product
 *
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property int $item_price
 * @property int $vat_percentage
 * @property bool $manages_inventory
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Inventory\Projections\Inventory|null $inventory
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereItemPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereManagesInventory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVatPercentage($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Domain\Customer\Customer|null $customer
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

