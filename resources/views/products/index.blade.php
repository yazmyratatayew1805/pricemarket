@php
/** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Domain\Product\Product[] $products */
@endphp




<x-app-layout title="Products">

sddssdf 
    <div class="grid grid-cols-3 gap-12">
        @foreach($products as $product)
            <x-product 
                :title="$product->name" 
                :price="format_money($product->getItemPrice()->pricePerItemIncludingVat())"
                :actionUrl="action(\App\Http\Controllers\Cart\AddCartItemController::class, [$product])"
          />
        @endforeach
    </div>




    <div class="mx-auto mt-12">
        {{ $products->links() }}
    </div>
</x-app-layout>
