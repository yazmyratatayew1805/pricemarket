<?php

namespace App\Domain\Cart\Projectors;

use App\Domain\Cart\Events\CartCheckedOut;
use App\Domain\Cart\Events\CartInitialized;
use App\Domain\Cart\Projections\CartDuration;
use Carbon\Carbon;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class CartDurationProjector extends Projector
{
    public function onCartInitialized(CartInitialized $event): void
    {
        /** @var \Spatie\EventSourcing\StoredEvents\StoredEvent $storedEvent */
        $storedEvent = EloquentStoredEvent::findOrFail($event->storedEventId());

        $createdAt = $storedEvent->created_at;

        (new CartDuration)->writeable()->create([
            'uuid' => $event->cartUuid,
            'cart_uuid' => $event->cartUuid,
            'created_at' => $createdAt,
        ]);
    }

    public function onCartCheckedOut(CartCheckedOut $event): void
    {
        /** @var \Spatie\EventSourcing\StoredEvents\StoredEvent $storedEvent */
        $storedEvent = EloquentStoredEvent::findOrFail($event->storedEventId());

        /** @var \Carbon\Carbon $checkedOutAt */
        $checkedOutAt = Carbon::make($storedEvent->created_at);

        /** @var \App\Domain\Cart\Projections\CartDuration $cartDuration */
        $cartDuration = CartDuration::where('cart_uuid', $event->cartUuid)->first();

        $cartDuration->writeable()->update([
            'checked_out_at' => $checkedOutAt,
            'duration_in_minutes' => $checkedOutAt->diffInMinutes($cartDuration->created_at),
        ]);
    }
}
