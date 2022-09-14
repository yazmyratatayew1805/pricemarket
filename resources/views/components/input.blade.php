@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'px-2 font-sans border-2 border-gray-300 focus:outline-none focus:border-red-400 focus:ring-0']) !!}>
