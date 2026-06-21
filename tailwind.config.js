import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                orange: {
                    DEFAULT: '#F97316',
                    dark: '#EA580C',
                },
                dark: {
                    DEFAULT: '#0A0A0A',
                    card: '#111111',
                    navy: '#0F172A',
                    section: '#111827',
                },
                muted: {
                    DEFAULT: '#9CA3AF',
                },
                border: 'rgba(255,255,255,0.08)',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
