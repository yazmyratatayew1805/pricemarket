<span class="px-2 py-3 border-b border-gray-200 {{ isset($total) ? 'font-semibold bg-red-100 bg-opacity-25' : ''}}">
    {{ $label ?? ''}}
</span>
<span class="px-2 py-3 border-b border-gray-200 font-display text-right {{ isset($total) ? 'bg-red-100 bg-opacity-25' : ''}}">
    {{ $slot }}
</span>
