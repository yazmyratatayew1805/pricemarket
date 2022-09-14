<?php

namespace App\Domain\Product;

use App\Support\MorphableModel;

// TODO: this interface must be removed and replaced by the product model
interface ProductInterface extends MorphableModel
{
    public function getUuid(): string;

    public function getName(): string;

    public function getItemPrice(): Price;
}
