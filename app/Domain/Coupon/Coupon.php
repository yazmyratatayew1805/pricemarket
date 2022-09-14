<?php

namespace App\Domain\Coupon;

use Database\Factories\CouponFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'reduction' => 'integer',
    ];

    protected static function newFactory(): CouponFactory
    {
        return new CouponFactory();
    }
}
