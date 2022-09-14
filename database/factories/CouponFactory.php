<?php

namespace Database\Factories;

use App\Domain\Coupon\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition(): array
    {
        return [
            'code' => 'code',
            'reduction' => 20_00,
        ];
    }
}
