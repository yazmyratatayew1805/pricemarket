<x-label for="{{ $name }}">{{ $label ?? ucfirst($name) }}</x-label>
<x-input class="p-2 w-full" name="{{ $name }}" id="{{ $name }}" value="{{ old($name) ?? $value ?? null }}"></x-input>

@error($name)
    <div class="text-red-400">{{ $message }}</div>
@enderror
