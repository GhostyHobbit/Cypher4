@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-text-default']) }}>
    {{ $value ?? $slot }}
</label>
