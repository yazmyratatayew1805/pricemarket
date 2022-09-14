<?php

namespace Tests\Domain\Inventory\Actions;

use App\Domain\Inventory\Actions\AddProductInventoryAction;
use App\Domain\Inventory\Actions\RemoveProductInventoryAction;
use App\Domain\Inventory\Queries\InventoryForProduct;
use App\Domain\Product\Product;
use Tests\Domain\Factories\ProductFactory;
use Tests\TestCase;

class AddProductInventoryTest extends TestCase
{
    private Product $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = ProductFactory::new()->withInventory(0)->create();
    }

    /** @test */
    public function can_add_inventory(): void
    {
        app(AddProductInventoryAction::class)($this->product, 10);

        $this->assertEquals(10, (new InventoryForProduct($this->product))->available());
    }

    /** @test */
    public function can_add_inventory_multiple_times(): void
    {
        app(AddProductInventoryAction::class)($this->product, 10);

        app(AddProductInventoryAction::class)($this->product, 10);

        $this->assertEquals(20, (new InventoryForProduct($this->product))->available());
    }

    /** @test */
    public function can_remove_inventory_multiple_times(): void
    {
        app(AddProductInventoryAction::class)($this->product, 10);

        app(AddProductInventoryAction::class)($this->product, 10);

        app(RemoveProductInventoryAction::class)($this->product, 10);

        $this->assertEquals(10, (new InventoryForProduct($this->product))->available());
    }
}
