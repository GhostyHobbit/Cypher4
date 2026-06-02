@props(['disabled' => false, 'rows' => 1])

<textarea
    @disabled($disabled)
    {{-- Alpine.js Logic --}}
    x-data="{
        resize() {
            $el.style.height = '0px';
            $el.style.height = $el.scrollHeight + 'px'
        }
    }"
    x-init="resize()"
    @input="resize()"
    {{-- End Logic --}}
    rows="{{ $rows }}"
    {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-background-light dark:text-text-default focus:border-accent_purple focus:ring-accent_purple rounded-md shadow-sm py-3 px-4 w-full overflow-hidden resize-none']) }}
>{{ $slot }}</textarea>
