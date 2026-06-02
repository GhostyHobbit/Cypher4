<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-6 py-3 bg-accent rounded-md font-bold text-background-default text-lg text-center transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
