<?php

namespace App\Http\Controllers\Products;

use App\Domain\Product\Product;

class ProductIndexController
{
    public function __invoke()
    {
        $products = Product::paginate();

        return view('products.index', ['products' => $products]);
    }
}
