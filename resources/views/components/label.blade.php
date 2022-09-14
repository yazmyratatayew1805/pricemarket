@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-gray-600']) }}>
    {{ $value ?? $slot }}
</label>
