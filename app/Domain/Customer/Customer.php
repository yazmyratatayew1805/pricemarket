<?php

namespace App\Domain\Customer;

use App\Domain\Cart\Enums\CartStatus;
use App\Domain\Cart\Projections\Cart;
use App\Domain\Order\Projections\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function activeCart(): HasOne
    {
        return $this
            ->hasOne(Cart::class)
            ->where('status', CartStatus::pending());
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
