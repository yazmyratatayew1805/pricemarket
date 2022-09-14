<?php

namespace Database\Factories;

use App\Domain\Product\Product;
use App\Support\Uuid;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'uuid' => Uuid::new(),
            'name' => strtoupper($this->faker->bothify('?????-##')),
            'item_price' => $this->faker->numberBetween(10_00, 1000_00),
            'vat_percentage' => $this->faker->randomElement([0, 6, 12, 21]),
            'category_id' => rand(1,2),
        ];
    }
}
