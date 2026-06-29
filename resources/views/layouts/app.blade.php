<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @php
            // Fetch current color mapping array coordinates
            $themeColors = \App\Themes\ThemeRegistry::getColorsForUser(Auth::user());
        @endphp

        <style id="user-theme-variables">
            :root {
                --color-bg-default: {{ $themeColors['bg-default'] }};
                --color-bg-dark: {{ $themeColors['bg-dark'] }};
                --color-bg-light: {{ $themeColors['bg-light'] }};
                --color-text-default: {{ $themeColors['text-default'] }};
                --color-text-light: {{ $themeColors['text-light'] }};
                --color-accent: {{ $themeColors['accent'] }};
                --color-accent-purple: {{ $themeColors['accent-purple'] }};
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
<body class="font-sans antialiased bg-background-default text-text-default flex flex-col h-screen overflow-hidden">
    <div class="h-14 px-4 flex items-center justify-between bg-background-dark shrink-0">
        <a href="{{ route('home') }}">
            <x-application-logo class="w-14"/>
        </a>
        <a href="{{ route('profile.edit') }}">
            <img src="{{ $user->image_src ? asset('storage/' . $user->image_src) : asset('images/apollopfp.jpg') }}" alt="profile_picture" class="rounded-full w-10 aspect-square object-cover transition-all group-hover:brightness-50"/>
        </a>
    </div>

    <div class="grid grid-cols-6 flex-1 overflow-hidden">
        <!-- Sidebar -->
        <div class="bg-background-dark pl-6 pr-12 space-y-4 overflow-y-auto scrollbar-hide">
            <div x-data="{ dropdownOpen: false }" class="relative w-full my-6 select-none">
                <div @click="dropdownOpen = !dropdownOpen" class="bg-accent w-full rounded-full py-2 text-center cursor-pointer hover:opacity-90 transition-opacity flex items-center justify-center gap-1">
                    <p class="text-background-default text-lg font-semibold">+ New</p>
                </div>
                <div x-show="dropdownOpen" @click.away="dropdownOpen = false" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                     class="absolute left-0 mt-2 w-full bg-background-default rounded-md shadow-xl z-50 overflow-hidden">
                    <div x-data="{ open: false }" class="py-3 pl-6 text-lg hover:bg-background-dark">
                        <p @click="open = true" class="cursor-pointer font-bold">+ Entry</p>
                        <x-entries.add-entry-modal :stack="null"/>
                    </div>
                    <div x-data="{ open: false }" class="py-3 pl-6 text-lg hover:bg-background-dark">
                        <p @click="open = true" class="cursor-pointer">+ Stack</p>
                        @include('entries.partials.add_stack_modal')
                    </div>
                    <div x-data="{ open: false }" class="py-3 pl-6 text-lg hover:bg-background-dark">
                        <p @click="open = true" class="cursor-pointer">+ Journal</p>
                        @include('journals.partials.add_journal_modal')
                    </div>
                </div>
            </div>
            <div x-data="{ open: false }">
                <div class="flex gap-2 items-center cursor-pointer select-none" @click="open = !open">
                    <div class="transform transition-transform duration-200 -rotate-90" :class="{ 'rotate-0': open }">
                        <x-icons.chevron class="w-5" />
                    </div>
                    <p class="text-xl">My Stacks</p>
                </div>
                <div x-show="open" x-cloak class="pl-6 space-y-4 mt-2">
                    @foreach($stacks as $stack)
                        <div x-data="{ stackOpen: false }">
                            <div class="flex gap-2 items-center cursor-pointer select-none group min-w-0">
                                <div @click="stackOpen = !stackOpen" class="transform transition-transform duration-200 text-text-light group-hover:text-text-default -rotate-90 shrink-0" :class="{ 'rotate-0': stackOpen }">
                                    <x-icons.chevron class="w-5" />
                                </div>
                                <a href="{{ route('stacks.show', $stack->id) }}" class="min-w-0 flex-1">
                                    <p class="text-xl truncate group-hover:text-text-light transition-colors">{{ $stack->title }}</p>
                                </a>
                            </div>

                            <div x-show="stackOpen" class="pl-9 space-y-2 mt-1">
                                @foreach($stack->entries as $entry)
                                    <a href="{{ route('entries.edit', $entry->id) }}"
                                       class="block truncate text-text-light hover:text-text-default transition-colors py-0.5">
                                        {{ $entry->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div x-data="{ open: false }">
                <div class="flex gap-2 items-center cursor-pointer select-none" @click="open = !open">
                    <div class="transform transition-transform duration-200 -rotate-90" :class="{ 'rotate-0': open }">
                        <x-icons.chevron class="w-5" />
                    </div>
                    <p class="text-xl">My Entries</p>
                </div>
                <div x-show="open" x-cloak class="pl-6 space-y-2 mt-2">
                    @foreach($entries as $entry)
                        <a href="{{ route('entries.edit', $entry->id) }}"
                           class="block truncate text-text-light hover:text-text-default transition-colors py-0.5">
                            {{ $entry->title }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div x-data="{ open: false }" class="pb-10">
                <div class="flex gap-2 items-center cursor-pointer select-none" @click="open = !open">
                    <div class="transform transition-transform duration-200 -rotate-90" :class="{ 'rotate-0': open }">
                        <x-icons.chevron class="w-5" />
                    </div>
                    <p class="text-xl">My Journals</p>
                </div>
                <div x-show="open" x-cloak class="pl-6 space-y-2 mt-2">
                    @foreach($journals as $journal)
                        <a href="{{ route('journals.show', $journal->id) }}"
                           class="block truncate text-text-light hover:text-text-default transition-colors py-0.5">
                            {{ $journal->title }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <main class="w-full h-full bg-background-default col-span-5 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
