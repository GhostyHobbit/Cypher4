@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-background-light dark:text-text-default focus:border-accent_purple focus:ring-accent_purple rounded-md shadow-sm py-3']) }}>
