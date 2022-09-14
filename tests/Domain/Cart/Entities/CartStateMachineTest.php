<?php

namespace Tests\Domain\Cart\Entities;

use App\Domain\Cart\Partials\CartStateMachine;
use Tests\Domain\Factories\Events\CartCheckedOutFactory;
use Tests\Domain\Factories\Events\CartFailedFactory;
use Tests\Domain\Factories\Events\CartLockedFactory;
use Tests\TestCase;

class CartStateMachineTest extends TestCase
{
    /** @test */
    public function changes_allowed_when_created(): void
    {
        $state = CartStateMachine::fake();

        $this->assertTrue($state->changesAllowed());
    }

    /** @test */
    public function changes_not_allowed_when_checked_out(): void
    {
        $state = CartStateMachine::fake();

        $state->applyCheckout(CartCheckedOutFactory::new()->create());

        $this->assertFalse($state->changesAllowed());
    }

    /** @test */
    public function changes_not_allowed_when_locked(): void
    {
        $state = CartStateMachine::fake();

        $state->applyLock(CartLockedFactory::new()->create());

        $this->assertFalse($state->changesAllowed());
    }

    /** @test */
    public function failed_cart_that_is_locked_stays_failed(): void
    {
        $state = CartStateMachine::fake();

        $state->applyLock(CartLockedFactory::new()->create());

        $state->applyFail(CartFailedFactory::new()->create());

        $this->assertTrue($state->isFailed());
    }

    /** @test */
    public function failed_cart_that_is_unlocked_transitions_back_to_pending(): void
    {
        $state = CartStateMachine::fake();

        $state->applyFail(CartFailedFactory::new()->create());

        $this->assertTrue($state->isPending());
    }
}
