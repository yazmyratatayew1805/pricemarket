@php
    /** @var \App\Domain\Cart\Projections\Cart|null $cart */
    /** @var \App\Domain\Customer\Customer $customer */
@endphp


<x-app-layout title="My Cart">
    @if($cart?->items?->isNotEmpty())
        <div class="grid grid-cols-2 gap-12 items-start">
            <section class="grid grid-cols-1 gap-4">
                @foreach($cart->items as $item)
                    <x-product 
                        :title="$item->product->name" 
                        :amount="$item->amount" 
                        :price="format_money($item->total_item_price_including_vat)"
                        :actionUrl="action(\App\Http\Controllers\Cart\RemoveCartItemController::class, [$item])"
                        actionLabel="Remove">
                    </x-product>
                @endforeach

                <div>
                    <p class="text-right">
                    </p>
                </div>
            </section>

            <section>
                <h2 class="font-display text-2xl">
                    Before checking out…
                </h2>

                <p>Please review and complete your checkout data.</p>

                <div class="my-12 grid grid-cols-[1fr,auto]">
                    <x-price-line label="Total Item Price">
                        {{ format_money($cart->total_item_price_including_vat) }}
                    </x-price-line>
                    
                    @if($cart->hasShippingCost())
                        <x-price-line label="Shipping">
                            {{ format_money($cart->shipping_costs_including_vat) }}
                        </x-price-line>
                    @endif

                    @if($cart->hasCoupon())
                        <x-price-line>
                            <x-slot name="label">
                                Coupon <code class="bg-gray-100 p-1 rounded">{{ $cart->coupon_code }}</code>
                                <a href="{{ action(\App\Http\Controllers\Cart\RemoveCouponController::class) }}" class="ml-6 underline hover:text-red-500">Remove</a>
                            </x-slot>

                            -{{ format_money($cart->coupon_reduction) }}
                        </x-price-line>
                    @else
                        <x-price-line label="Coupon">
                            <form action="{{ action(\App\Http\Controllers\Cart\UseCouponController::class) }}" method="POST">
                                @csrf

                                <div class="flex">
                                    <x-input name="code"></x-input>
                                    <x-button>Use code</x-button>
                                </div>
                            </form>
                        </x-price-line>
                    @endif

                    <x-price-line label="Total Price" total>
                        {{ format_money($cart->totalPrice()) }}
                    </x-price-line>
                   
                </div>

                <form action="{{ action(\App\Http\Controllers\Cart\CheckoutController::class) }}" method="post">
                    @csrf

                    <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                        <div class="col-span-2">
                            <x-field name="street" :value="$customer->street"></x-field>
                        </div>

                        <div>
                            <x-field name="number" :value="$customer->number"></x-field>
                        </div>

                        <div>
                            <x-field name="postal" :value="$customer->postal"></x-field>
                        </div>
                        
                        <div class="col-span-2">
                            <x-field name="city" :value="$customer->city"></x-field>
                        </div>
                   
                        <div class="col-span-3">
                            <x-field name="country" :value="$customer->country"></x-field>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-end">
                        <x-button>Checkout</x-button>
                    </div>
                </form>
            </section>
        </div>
    @else
        <x-note>
            No items added, <a class="underline hover:text-red-500" href="{{ action(\App\Http\Controllers\Products\ProductIndexController::class) }}">browse our products</a>.
        </x-note>
    @endif
</x-app-layout>
