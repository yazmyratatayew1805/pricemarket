<?php

namespace App\Domain\Order\Projections;

use App\Domain\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EventSourcing\Projections\Projection;

class OrderLine extends Projection
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

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
