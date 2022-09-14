<?php

namespace App\Domain\Inventory\Projections;

use App\Domain\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EventSourcing\Projections\Projection;

class Inventory extends Projection
{
    protected $guarded = [];

    protected $casts = [
        'amount' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
