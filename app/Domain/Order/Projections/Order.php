<?php

namespace App\Domain\Order\Projections;

use App\Domain\Cart\Projections\Cart;
use App\Domain\Customer\Customer;
use App\Domain\Order\Projections\Query\OrderQueryBuilder;
use App\Domain\Order\Projections\States\OrderState;
use App\Domain\Payment\Projections\Payment;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\EventSourcing\Projections\Projection;

class Order extends Projection
{
    protected $guarded = [];

    protected $casts = [
        'total_item_price_excluding_vat' => 'integer',
        'total_item_price_including_vat' => 'integer',
        'state' => OrderState::class,
        'canceled_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'shipping_costs_vat_percentage' => 'integer',
        'shipping_costs_excluding_vat' => 'integer',
        'shipping_costs_including_vat' => 'integer',
        'coupon_reduction' => 'integer',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }

    public function newEloquentBuilder($query): OrderQueryBuilder
    {
        return new OrderQueryBuilder($query);
    }

    public function shouldBePaid(): bool
    {
        return $this->payment->state->shouldBePaid();
    }

    public function isPaid(): bool
    {
        return $this->payment->state->isPaid();
    }

    public function hasShippingCost(): bool
    {
        return $this->shipping_costs_including_vat !== null;
    }

    public function hasCoupon(): bool
    {
        return $this->coupon_reduction !== null;
    }

    public function totalPrice(): int
    {
        $totalPrice = $this->total_item_price_including_vat;

        if ($this->hasShippingCost()) {
            $totalPrice += $this->shipping_costs_including_vat;
        }

        if ($this->hasCoupon()) {
            $totalPrice -= $this->coupon_reduction;
        }

        if ($totalPrice < 0) {
            $totalPrice = 0;
        }

        return $totalPrice;
    }
}
