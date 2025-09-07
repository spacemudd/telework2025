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
            fontFamily: {
                sans: ['Zain', '"IBM Plex Arabic"', 'Figtree', ...defaultTheme.fontFamily.sans],
                zain: ['Zain', 'sans-serif'],
            },
        },
    },

    plugins: [forms],
};
