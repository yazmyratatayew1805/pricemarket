<?php

namespace Tests\Domain\Integration;

use App\Domain\Cart\Projections\Cart;
use Tests\Domain\Factories\CartAggregateFactory;
use Tests\TestCase;

class RebuildTest extends TestCase
{
    /** @test */
    public function it_can_rebuild_projections(): void
    {
        $cart = CartAggregateFactory::new()->create();

        $this->assertDatabaseHas((new Cart)->getTable(), [
            'uuid' => $cart->uuid,
        ]);

        $this
            ->artisan('event-sourcing:replay "App\\\\Domain\\\\Cart\\\\Projectors\\\\CartProjector"')
            ->execute();

        $this->assertDatabaseHas((new Cart)->getTable(), [
            'uuid' => $cart->uuid,
        ]);
    }
}
