<?php

namespace App\Domain\Cart\Projections;

use App\Domain\Cart\Projections\Collections\CartItemCollection;
use App\Domain\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EventSourcing\Projections\Projection;

class CartItem extends Projection
{
    protected $guarded = [];

    protected $casts = [
        'price_per_item_excluding_vat' => 'integer',
        'price_per_item_including_vat' => 'integer',
        'vat_percentage' => 'integer',
        'vat_price' => 'integer',
        'total_item_price_excluding_vat' => 'integer',
        'total_item_price_including_vat' => 'integer',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function newCollection(array $models = []): CartItemCollection
    {
        return new CartItemCollection($models);
    }
}
