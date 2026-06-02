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
            $themeColors = \App\Themes\ThemeRegistry::getColorsForUser(null);
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
    </head>
    <body class="font-sans bg-background-default antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-[30%] px-6 py-12 bg-background-dark shadow-md overflow-hidden sm:rounded-lg">
                <div class="mb-8">
                    <x-logo-and-text class="w-52"/>
                </div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
