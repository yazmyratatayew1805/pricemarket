<?php

namespace App\Domain\Cart\Projections\Collections;

use App\Domain\Cart\Projections\CartItem;
use Illuminate\Database\Eloquent\Collection;

class CartItemCollection extends Collection
{
    public function totalPriceExcludingVat(): int
    {
        return $this->sum(
            fn (CartItem $cartItem) => $cartItem->total_item_price_including_vat
        );
    }

    public function totalPriceIncludingVat(): int
    {
        return $this->sum(
            fn (CartItem $cartItem) => $cartItem->total_item_price_including_vat
        );
    }
}
