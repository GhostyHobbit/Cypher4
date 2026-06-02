@props(['cat' => true])

@php
    $colorClass = $cat ? 'bg-accent text-background-dark' : 'bg-accent_purple text-text-default';
@endphp

<div class="mt-4">
    <a {{ $attributes->merge(['class' => "px-4 py-2 rounded-md font-bold text-md text-center transition ease-in-out duration-150 $colorClass"]) }}>
        {{ $slot }}
    </a>
</div>
