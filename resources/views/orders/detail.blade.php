@php
    /** @var \App\Domain\Order\Projections\Order $order */
@endphp

<x-app-layout :title="'Order ' . $order->order_number">
    <x-slot name="breadcrumb">
        <div class="mb-12 font-display text-4xl flex items-center space-x-4">
            <a class="underline hover:text-red-500" href="{{ action(\App\Http\Controllers\Orders\OrderIndexController::class) }}">My Orders</a> 
            <span class="text-gray-500 text-base">></span>
            <span>{{ $order->order_number }}</span>
        </div>
    </x-slot>

    <div class="grid grid-cols-2 gap-12 items-start">
        <section class="grid grid-cols-1 gap-4">
            @foreach($order->lines as $line)
                <x-product :title="$line->description" :amount="$line->amount" :price="format_money($line->total_item_price_including_vat)"/>
            @endforeach
        </section>

        <section>
            <div class="grid grid-cols-[1fr,auto]">
                <x-price-line label="Status">
                    <div class="{{ $order->state->color() }}">{{ $order->state->label() }}</div>
                </x-price-line>
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

            <div class="mt-12 flex justify-end">
                @if($order->shouldBePaid())
                    <a class="underline hover:text-red-500 mr-4" href="{{ action(\App\Http\Controllers\Payment\FailController::class, [$order->payment]) }}">Cancel order</a>
                    <a href="{{ action(\App\Http\Controllers\Payment\PayController::class, [$order->payment]) }}">
                        <x-button type="button">Pay now</x-button>
                    </a>
                @endif

                @if($order->isPaid())
                    <a target="_blank" href="{{ action(\App\Http\Controllers\Orders\OrderPdfController::class, [$order]) }}">
                        <x-button type="button">PDF</x-button>
                    </a>
                @endif
            </div>
        </section>
    </div>
</x-app-layout>
