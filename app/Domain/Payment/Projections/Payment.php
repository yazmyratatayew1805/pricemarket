<?php

namespace App\Domain\Payment\Projections;

use App\Domain\Order\Projections\Order;
use App\Domain\Payment\States\PaymentState;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EventSourcing\Projections\Projection;

class Payment extends Projection
{
    protected $guarded = [];

    protected $casts = [
        'total_item_price_including_vat' => 'integer',
        'state' => PaymentState::class,
        'failed_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
