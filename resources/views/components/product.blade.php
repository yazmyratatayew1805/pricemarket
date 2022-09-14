<div {{ $attributes->merge(['class'=>'bg-gray-100 border-l-8 border-gray-200'])->except(['title', 'price', 'action']) }}>
    <div class="p-4 flex items-center border border-gray-100">
        <div class="w-16 h-16 bg-white flex items-center justify-center border border-gray-300">
            <x-logo-outline class="w-8 h-8"/>
        </div>

        <div class="flex-grow ml-4">
            <h3 class="flex justify-between font-semibold text-lg">
                <span>{{ $title ?? '' }}</span>
                @isset($amount)
                    {{ $amount }} &times;
                @endisset
            </h3>
            <div class="text-green-500 font-display">{{ $price ?? '' }}</div>
        </div>
    </div>
    @php
        use Illuminate\Support\Facades\Auth;
    @endphp

    @isset($actionUrl)
        <div class="px-4 pb-4 flex justify-end">
            <a href="{{ Auth::user() ? $actionUrl : route('login') }}">
                <x-button type="button">
                    {{ Auth::user() ? $actionLabel ?? 'Add to cart' : 'Log in' }}
                </x-button>
            </a>
        </div>
    @endisset
</div>
