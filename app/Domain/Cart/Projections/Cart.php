<?php

namespace App\Domain\Cart\Projections;

use App\Domain\Cart\Enums\CartLockStatus;
use App\Domain\Cart\Enums\CartStatus;
use App\Domain\Customer\Customer;
use App\Domain\Order\Projections\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\EventSourcing\Projections\Projection;

class Cart extends Projection
{
    protected $guarded = [];

    protected $casts = [
        'total_item_price_excluding_vat' => 'integer',
        'total_item_price_including_vat' => 'integer',
        'status' => CartStatus::class,
        'lock_status' => CartLockStatus::class,
        'coupon_reduction' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
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
