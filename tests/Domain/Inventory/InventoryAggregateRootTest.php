<?php

namespace Tests\Domain\Inventory;

use App\Domain\Inventory\Commands\AddProductInventory;
use App\Domain\Inventory\Commands\RemoveProductInventory;
use App\Domain\Inventory\Exceptions\InsufficientInventoryAvailable;
use App\Domain\Inventory\InventoryAggregateRoot;
use App\Domain\Product\Product;
use Tests\Domain\Factories\Events\ProductInventoryAddedFactory;
use Tests\Domain\Factories\Events\ProductInventoryRemovedFactory;
use Tests\Domain\Factories\ProductFactory;
use Tests\TestCase;

class InventoryAggregateRootTest extends TestCase
{
    private const INVENTORY_UUID = 'inventory-uuid';

    private Product $product;

    private ProductInventoryAddedFactory $productInventoryAddedFactory;

    private ProductInventoryRemovedFactory $productInventoryRemovedFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = ProductFactory::new()->withInventory(0)->create();

        $this->productInventoryAddedFactory = ProductInventoryAddedFactory::new()
            ->withInventoryUuid(self::INVENTORY_UUID)
            ->withProduct($this->product);

        $this->productInventoryRemovedFactory = ProductInventoryRemovedFactory::new()
            ->withInventoryUuid(self::INVENTORY_UUID)
            ->withProduct($this->product);
    }

    /** @test */
    public function can_add_inventory_for_new_product(): void
    {
        InventoryAggregateRoot::fake(self::INVENTORY_UUID)
            ->given([])
            ->when(function (InventoryAggregateRoot $inventoryAggregateRoot): void {
                $inventoryAggregateRoot->addInventory(
                    new AddProductInventory(
                        $this->product->uuid,
                        $this->product,
                        10
                    )
                );
            })
            ->assertRecorded([
                $this->productInventoryAddedFactory->withAmount(10)->create(),
            ]);
    }

    /** @test */
    public function can_add_inventory_for_existing_product(): void
    {
        InventoryAggregateRoot::fake(self::INVENTORY_UUID)
            ->given([
                $this->productInventoryAddedFactory->withAmount(10)->create(),
            ])
            ->when(function (InventoryAggregateRoot $inventoryAggregateRoot): void {
                $inventoryAggregateRoot->addInventory(
                    new AddProductInventory(
                        $this->product->uuid,
                        $this->product,
                        10
                    )
                );
            })
            ->assertRecorded([
                $this->productInventoryAddedFactory->withAmount(10)->create(),
            ]);
    }

    /** @test */
    public function can_remove_inventory_for_existing_product(): void
    {
        InventoryAggregateRoot::fake(self::INVENTORY_UUID)
            ->given([
                $this->productInventoryAddedFactory->withAmount(10)->create(),
            ])
            ->when(function (InventoryAggregateRoot $inventoryAggregateRoot): void {
                $inventoryAggregateRoot->removeInventory(
                    new RemoveProductInventory(
                        $this->product->uuid,
                        $this->product,
                        10
                    )
                );
            })
            ->assertRecorded([
                $this->productInventoryRemovedFactory->withAmount(10)->create(),
            ]);
    }

    /** @test */
    public function cannot_remove_inventory_when_not_enough_available(): void
    {
        InventoryAggregateRoot::fake(self::INVENTORY_UUID)
            ->given([
                $this->productInventoryAddedFactory->withAmount(10)->create(),
            ])
            ->when(function (InventoryAggregateRoot $inventoryAggregateRoot): void {
                $this->assertExceptionThrown(
                    fn () => $inventoryAggregateRoot->removeInventory(
                        new RemoveProductInventory(
                            $this->product->uuid,
                            $this->product,
                            20
                        )
                    ),
                    InsufficientInventoryAvailable::class
                );
            });
    }

    /** @test */
    public function cannot_remove_inventory_when_none_available(): void
    {
        InventoryAggregateRoot::fake(self::INVENTORY_UUID)
            ->given([])
            ->when(function (InventoryAggregateRoot $inventoryAggregateRoot): void {
                $this->assertExceptionThrown(
                    fn () => $inventoryAggregateRoot->removeInventory(
                        new RemoveProductInventory(
                            $this->product->uuid,
                            $this->product,
                            20
                        )
                    ),
                    InsufficientInventoryAvailable::class
                );
            });
    }
}
