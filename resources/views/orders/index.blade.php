@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator|\App\Domain\Order\Projections\Order[] $orders */
    /** @var \App\Domain\Order\Projections\Order $order */
@endphp

<x-app-layout title="My Orders">

    <table class="w-full">
        <thead>
            <tr class="bg-gray-50 border-b border-gray-200">
                <th class="text-left uppercase text-gray-600 text-xs px-4 py-2">
                    Order
                </th>
                <th class="text-left uppercase text-gray-600 text-xs px-4 py-2">
                    Status
                </th>
                <th class="text-left uppercase text-gray-600 text-xs px-4 py-2">
                    Created
                </th>
                <th class="text-left uppercase text-gray-600 text-xs px-4 py-2">
                    Total
                </th>
                <th class="text-left uppercase text-gray-600 text-xs px-4 py-2">
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr class="border-b border-gray-200">
                    <td class="px-4 py-2">
                        <h2>
                            <a href="{{ action(\App\Http\Controllers\Orders\OrderDetailController::class, [$order]) }}" class="underline hover:text-red-500 font-bold">
                                {{ $order->order_number }}
                            </a>
                        </h2>
                    </td>
                    
                    <td class="px-4 py-2 {{ $order->state->color() }}">
                        {{ $order->state->label() }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $order->created_at->format('Y-m-d H:i') }}
                    </td>
                    <td class="px-4 py-2 font-semibold">
                        {{ format_money($order->total_item_price_including_vat) }}
                    </td>

                    <td class="px-4 py-2 text-right whitespace-nowrap">
                        @if($order->shouldBePaid())
                            <a class="underline hover:text-red-500 mr-4" href="{{ action(\App\Http\Controllers\Payment\FailController::class, [$order->payment]) }}">Cancel order</a>
                            <a href="{{ action(\App\Http\Controllers\Payment\PayController::class, [$order->payment]) }}">
                                <x-button type="button">Pay Now</x-button>
                            </a>
                        @endif

                        @if($order->isPaid())
                            <a target="_blank" href="{{ action(\App\Http\Controllers\Orders\OrderPdfController::class, [$order]) }}">
                                <x-button type="button">PDF</x-button>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mx-auto mt-12">
        {{ $orders->links() }}
    </div>
</x-app-layout>
