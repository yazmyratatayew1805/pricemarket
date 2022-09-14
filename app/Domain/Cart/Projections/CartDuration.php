<?php

namespace App\Domain\Cart\Projections;

use Spatie\EventSourcing\Projections\Projection;

class CartDuration extends Projection
{
    protected $guarded = [];

    public $timestamps = [];

    protected $casts = [
        'created_at' => 'datetime',
        'checked_out_at' => 'datetime',
        'duration_in_minutes' => 'integer',
    ];
}
