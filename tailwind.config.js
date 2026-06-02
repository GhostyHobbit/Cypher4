import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import scrollbarHide from 'tailwind-scrollbar-hide';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                'lumanosimo': ['Lumanosimo', 'monospace'],
                'oxanium': ['Oxanium', 'sans-serif'],
            },
            colors: {
                // We read from active CSS variables.
                // Specifying <alpha-value> lets utility opacity modifiers (like bg-opacity-50) still work!
                'background-default': 'rgb(var(--color-bg-default) / <alpha-value>)',
                'background-dark': 'rgb(var(--color-bg-dark) / <alpha-value>)',
                'background-light': 'rgb(var(--color-bg-light) / <alpha-value>)',
                'text-default': 'rgb(var(--color-text-default) / <alpha-value>)',
                'text-light': 'rgb(var(--color-text-light) / <alpha-value>)',
                'accent': 'rgb(var(--color-accent) / <alpha-value>)',
                'accent_purple': 'rgb(var(--color-accent-purple) / <alpha-value>)',
            },
            typography: {
                DEFAULT: {
                    css: {
                        '--tw-prose-body': 'var(--color-text-default)',
                        '--tw-prose-headings': 'var(--color-text-default)',
                        '--tw-prose-bold': 'var(--color-text-default)',
                        '--tw-prose-counters': 'var(--color-text-light)',
                        '--tw-prose-bullets': 'rgb(var(--color-accent))',
                        '--tw-prose-links': 'rgb(var(--color-accent-purple))',
                        'ul, ol': {
                            marginTop: '0.75rem',
                            marginBottom: '0.75rem',
                            paddingLeft: '1.25rem',
                        },
                        'li': {
                            marginTop: '0.125rem',
                            marginBottom: '0.125rem',
                        },
                        'li p': {
                            marginTop: '0px',
                            marginBottom: '0px',
                        },
                    },
                },
            },
        },
    },

    plugins: [
        forms,
        scrollbarHide,
        typography,
    ],
};
