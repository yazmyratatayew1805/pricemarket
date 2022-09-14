@php
    /** @var \App\Domain\Order\Projections\Order $order */
@endphp

<x-pdf-layout>
    <div class="flex items-center">
        <x-logo class="w-8 h-8 mr-4"/>
        <span class="font-display font-black uppercase text-xl tracking-wider">Laravel Shop | Invoice</span>
    </div>
    <h2 class="my-12 font-display font-black text-4xl">
       {{ $order->order_number }}
    </h2>
    <div class="mt-12 grid grid-cols-2 gap-12 items-start">
        <section class="grid grid-cols-1 gap-4">
            @foreach($order->lines as $line)
                <x-product :title="$line->description" :amount="$line->amount" :price="format_money($line->total_item_price_including_vat)"/>
            @endforeach
        </section>

        <section>
            <div class="grid grid-cols-[1fr,auto]">
                <x-price-line label="Total Item Price">
                    {{ format_money($order->total_item_price_including_vat) }}
                </x-price-line>
                @if($order->hasShippingCost())
                    <x-price-line label="Shipping">
                        {{ format_money($order->shipping_costs_including_vat) }}
                    </x-price-line>
                @endif
                @if($order->hasCoupon())
                    <x-price-line label="Shipping">
                        <x-slot name="label">
                            Coupon <code class="bg-gray-100 p-1 rounded">{{ $order->coupon_code }}</code>
                        </x-slot>

                        -{{ format_money($order->coupon_reduction) }}
                    </x-price-line>
                @endif
                <x-price-line label="Total Price" total>
                    {{ format_money($order->totalPrice()) }}
                </x-price-line>
            </div>
        </section>
    </div>
</x-pdf-layout>
