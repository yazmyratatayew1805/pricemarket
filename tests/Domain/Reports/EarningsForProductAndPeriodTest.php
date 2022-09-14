<?php

namespace Tests\Domain\Reports;

use App\Domain\Product\Product;
use App\Domain\Reports\EarningsForProductAndPeriod;
use Carbon\Carbon;
use Spatie\Period\Period;
use Tests\Domain\Factories\OrderAggregateFactory;
use Tests\Domain\Factories\ProductFactory;
use Tests\TestCase;

class EarningsForProductAndPeriodTest extends TestCase
{
    private Product $productA;

    private Product $productB;

    private Product $productC;

    public function setUp(): void
    {
        parent::setUp();

        $this->productA = ProductFactory::new()->withItemPrice(10_00)->create();
        $this->productB = ProductFactory::new()->withItemPrice(15_00)->create();
        $this->productC = ProductFactory::new()->withItemPrice(5_00)->create();

        OrderAggregateFactory::new()
            ->withProduct($this->productA, 1) // 10_00
            ->withProduct($this->productB, 2) // 30_00
            ->onDate(Carbon::make('2020-01-01'))
            ->create();

        OrderAggregateFactory::new()
            ->withProduct($this->productB, 2) // 30_00
            ->withProduct($this->productC, 1) // 5_00
            ->onDate(Carbon::make('2020-02-01'))
            ->create();

        OrderAggregateFactory::new()
            ->withProduct($this->productA, 1) // 10_00
            ->withProduct($this->productB, 1) // 15_00
            ->withProduct($this->productC, 2) // 10_00
            ->onDate(Carbon::make('2020-03-01'))
            ->create();
    }

    /** @test */
    public function test_report_generation(): void
    {
        $report = new EarningsForProductAndPeriod(
            Period::make('2020-01-01', '2020-02-01'),
            collect([$this->productA, $this->productB]),
        );

        $this->assertEquals(70_00, $report->totalPrice());
    }
}
